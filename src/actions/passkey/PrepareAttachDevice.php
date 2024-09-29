<?php

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\PasskeyRp;
use Webauthn\AuthenticatorSelectionCriteria;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialDescriptor;
use yii\web\ServerErrorHttpException;
use Yii;

class PrepareAttachDevice extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if(Yii::$app->user->isGuest) {
            throw new ServerErrorHttpException('User is not logged in');
        }
        $passkeyRp = Yii::createObject(PasskeyRp::class);
        /* @var $passkeyRp PasskeyRp */
        if (!$passkeyRp->validate()) {
            throw new ServerErrorHttpException('Failed to validate RP');
        }
        $publicKeyCredentialRp = $passkeyRp->getPublicKeyCredentialRpEntity();
        $administrator = Yii::$app->user->getIdentity();
        /** @var Administrator $administrator */

        $publicKeyCredentialUser = $administrator->getPublicKeyCredentialUserEntity();

        $challenge = random_bytes($this->challengeLength);

        $authenticatorSelectionCriteria = AuthenticatorSelectionCriteria::create(
            authenticatorAttachment: $this->authenticatorAttachment,
            userVerification: AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_REQUIRED,
            residentKey: AuthenticatorSelectionCriteria::RESIDENT_KEY_REQUIREMENT_REQUIRED,
        );
        $passkeys = $administrator->getPasskeys()->all();
        $excludeCredentials = [];
        foreach ($passkeys as $passkey) {
            $excludeCredentials[] = PublicKeyCredentialDescriptor::create('public-key', $this->base64UrlDecode($passkey->id));
        }
        $publicKeyCredentialRequestOptions =
            PublicKeyCredentialCreationOptions::create(
                challenge: $challenge,
                user: $publicKeyCredentialUser,
                rp: $publicKeyCredentialRp,
                authenticatorSelection: $authenticatorSelectionCriteria,
                excludeCredentials: $excludeCredentials

            )
        ;
        Yii::$app->session->set('publicKeyCredentialUser', $publicKeyCredentialUser);
        Yii::$app->session->set('challenge', $challenge);

        return $this->toArray($publicKeyCredentialRequestOptions);
    }
}