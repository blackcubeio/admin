<?php

namespace blackcube\admin\actions\passkey;

use Webauthn\AuthenticatorSelectionCriteria;
use Webauthn\PublicKeyCredentialRequestOptions;
use Yii;

class PrepareLoginDevice extends BaseAction
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
        $challenge = random_bytes($this->challengeLength);
        Yii::$app->session->set('challenge', $challenge);
        $publicKeyCredentialRequestOptions = PublicKeyCredentialRequestOptions::create(
            $challenge,
            userVerification: PublicKeyCredentialRequestOptions::USER_VERIFICATION_REQUIREMENT_REQUIRED
        );
        Yii::$app->session->set('publicKeyCredentialRequestOptions', $publicKeyCredentialRequestOptions);

        return $this->toArray($publicKeyCredentialRequestOptions);
    }
}