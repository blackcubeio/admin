<?php

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\Passkey;
use blackcube\admin\models\PasskeyRp;
use Webauthn\AuthenticatorSelectionCriteria;
use Webauthn\PublicKeyCredentialDescriptor;
use Webauthn\PublicKeyCredentialRequestOptions;
use Webauthn\PublicKeyCredentialSource;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\ServerErrorHttpException;

class PrepareLogin extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public $authenticatorAttachment = AuthenticatorSelectionCriteria::AUTHENTICATOR_ATTACHMENT_CROSS_PLATFORM;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $passkeyRp = Yii::createObject(PasskeyRp::class);
        $administrator = Administrator::find()
            ->andWhere(['email' => Yii::$app->request->getBodyParam('name')])
            ->one();
        if ($administrator === null) {
            throw new NotFoundHttpException();
        }
        if ($passkeyRp->validate() === false) {
            throw new ServerErrorHttpException('Failed to validate RP');
        }
        $publicKeyRp = $passkeyRp->getPublicKeyCredentialRpEntity();


        $allowedCredentials = array_map(
            function (Passkey $passkey): PublicKeyCredentialDescriptor {
                $credential = $this->toObject($passkey->jsonData, PublicKeyCredentialSource::class);
                return $credential->getPublicKeyCredentialDescriptor();
            },
            /* @var Administrator $administrator */
            $administrator->getPasskeys()->all()
        );


        $challenge = random_bytes($this->challengeLength);
        Yii::$app->session->set('challenge', $challenge);
        $publicKeyCredentialRequestOptions = PublicKeyCredentialRequestOptions::create(
            $challenge,
            userVerification: PublicKeyCredentialRequestOptions::USER_VERIFICATION_REQUIREMENT_REQUIRED,
            rpId: $publicKeyRp->id,
            allowCredentials: $allowedCredentials
        );
        Yii::$app->session->set('publicKeyCredentialRequestOptions', $publicKeyCredentialRequestOptions);

        return $this->toArray($publicKeyCredentialRequestOptions);
    }
}