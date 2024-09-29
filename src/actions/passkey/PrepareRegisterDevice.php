<?php

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\PasskeyRp;
use Cose\Algorithms;
use Webauthn\AuthenticatorSelectionCriteria;
use Webauthn\PublicKeyCredentialCreationOptions;
use Webauthn\PublicKeyCredentialDescriptor;
use Webauthn\PublicKeyCredentialParameters;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use Yii;

class PrepareRegisterDevice extends BaseAction
{
    /**
     * {@inheritdoc}
     */
    public $authenticatorAttachment = AuthenticatorSelectionCriteria::AUTHENTICATOR_ATTACHMENT_PLATFORM;
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

        $administrator = Yii::$app->user->getIdentity();
        if ($administrator === null) {
            $administrator = Yii::createObject(Administrator::class);
        }
        $administrator->load(Yii::$app->request->bodyParams, '');
        $administrator->scenario = Administrator::SCENARIO_PASSKEY_REGISTER;
        if (!$administrator->save()) {
            throw new BadRequestHttpException('Invalid user');
        }
        $publicKeyCredentialUser = $administrator->getPublicKeyCredentialUserEntity();

        $challenge = random_bytes($this->challengeLength);

        Yii::$app->session->set('publicKeyCredentialUser', $publicKeyCredentialUser);
        Yii::$app->session->set('challenge', $challenge);

        $credentialsParameters = [
            PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_ES256K),
            PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_ES256),
            PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_RS256),
            PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_PS256),
            PublicKeyCredentialParameters::create('public-key', Algorithms::COSE_ALGORITHM_ED256),
        ];
        $authenticatorSelection = AuthenticatorSelectionCriteria::create(
            authenticatorAttachment: $this->authenticatorAttachment,
            residentKey: AuthenticatorSelectionCriteria::RESIDENT_KEY_REQUIREMENT_REQUIRED,
        );



        $publicKeyCredentialCreationOptions = new PublicKeyCredentialCreationOptions(
            rp: $publicKeyCredentialRp,
            user: $publicKeyCredentialUser,
            challenge: $challenge,
            pubKeyCredParams: $credentialsParameters,
            authenticatorSelection: $authenticatorSelection,
            attestation: null,
            excludeCredentials: [],
            timeout: $this->timeout,
            extensions: null
        );

        return $this->toArray($publicKeyCredentialCreationOptions);
    }
}