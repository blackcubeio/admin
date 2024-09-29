<?php

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\PasskeyRp;
use Webauthn\AuthenticatorAttestationResponse;
use Webauthn\PublicKeyCredential;
use Webauthn\PublicKeyCredentialCreationOptions;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use Yii;

class ValidateRegister extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $passkeyRp = Yii::createObject(PasskeyRp::class);
        if (!$passkeyRp->validate()) {
            throw new ServerErrorHttpException('Failed to validate RP');
        }
        $publicKeyCredentialRp = $passkeyRp->getPublicKeyCredentialRpEntity();
        $challenge = Yii::$app->session->get('challenge');
        $publicKeyCredentialUser = Yii::$app->session->get('publicKeyCredentialUser');
        Yii::$app->session->remove('publicKeyCredentialUser');
        Yii::$app->session->remove('challenge');

        $publicKeyCredential = $this->toObject(Yii::$app->request->bodyParams, PublicKeyCredential::class);
        if (!$publicKeyCredential->response instanceof AuthenticatorAttestationResponse) {
            throw new BadRequestHttpException('Invalid response type');
        }


        $administrator = Administrator::find()
            ->andWhere(['email' => $publicKeyCredentialUser->name])
            ->one();
        if ($administrator === null) {
            $administrator = Yii::createObject(Administrator::class);
            $administrator->email = $publicKeyCredentialUser->name;
            $administrator->setDisplayName($publicKeyCredentialUser->displayName);
            $administrator->scenario = Administrator::SCENARIO_PASSKEY_REGISTER;
        }

        $publicKeyCredentialCreationOptions =
            PublicKeyCredentialCreationOptions::create(
                $publicKeyCredentialRp,
                $publicKeyCredentialUser,
                $challenge,
                //todo: excludeCredentials should be defined
                excludeCredentials: [],
            )
        ;
        try {
            $publicKeyCredentialSource = $this->getCheckAttestationCeremony()->check(
                $publicKeyCredential->response,
                $publicKeyCredentialCreationOptions,
                $publicKeyCredentialRp->id,
            );
            $status = $this->savePasskey($publicKeyCredentialSource);
            if ($status === true) {
                // register the user
                    return ['success' => true];
            } else {
                $administrator->delete();
                return ['success' => false, 'errors' => $status];
            }
        } catch (\Exception $e) {
            $administrator->delete();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}