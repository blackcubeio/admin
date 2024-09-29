<?php

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\Passkey;
use blackcube\admin\models\PasskeyRp;
use Webauthn\PublicKeyCredential;
use Webauthn\PublicKeyCredentialSource;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use Yii;

class ValidateLogin extends BaseAction
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

        $webauthnCredentialSourceId = Yii::$app->request->getBodyParam('id');
        $webauthnCredentialSource = Passkey::find()
            ->andWhere(['id' => $webauthnCredentialSourceId])
            ->one();
        if ($webauthnCredentialSource === null) {
            throw new NotFoundHttpException();
        }
        $administrator = $webauthnCredentialSource->getAdministrator()->one();
        /* @var Administrator $administrator */
        if ($administrator === null) {
            throw new NotFoundHttpException();
        }

        $publicKeyCredentialUser = $administrator->getPublicKeyCredentialUserEntity();
        $credentialSource = $this->toObject($webauthnCredentialSource->jsonData, PublicKeyCredentialSource::class);
        $data = Yii::$app->request->bodyParams;
        $data['challenge'] = $this->base64UrlEncode(Yii::$app->session->get('challenge'));
        $publicKeyCredentialRequestOptions = Yii::$app->session->get('publicKeyCredentialRequestOptions');
        Yii::$app->session->remove('publicKeyCredentialRequestOptions');
        Yii::$app->session->remove('challenge');

        $publicKeyCredential = $this->toObject($data, PublicKeyCredential::class);
        if (!$publicKeyCredential->response instanceof \Webauthn\AuthenticatorAssertionResponse) {
            throw new BadRequestHttpException('Invalid response type');
        }

        try {
            $publicKeyCredentialSource = $this->getCheckAssertionCeremony()->check(
                $credentialSource,
                $publicKeyCredential->response,
                $publicKeyCredentialRequestOptions,
                $publicKeyCredentialRp->id,
                $publicKeyCredentialUser?->id // Should be `null` if the user entity is not known before this step
            );
            $webauthnCredentialSource->counter = $publicKeyCredentialSource->counter;
            $webauthnCredentialSource->save();
            Yii::$app->user->login($administrator);
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}