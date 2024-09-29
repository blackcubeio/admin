<?php

namespace blackcube\admin\models;

use blackcube\admin\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%webauthnCredentialSources}}".
 *
 * @property string $id
 * @property string $name
 * @property int $administratorId
 * @property string $type
 * @property string|null $attestationType
 * @property string|null $aaguid
 * @property string|null $credentialPublicKey
 * @property string|null $userHandle
 * @property int|null $counter
 * @property string|null $jsonData
 * @property string $dateCreate
 * @property string $dateUpdate
 *
 * @property Administrator $user
 */
class Passkey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors() :array
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'dateCreate',
            'updatedAtAttribute' => 'dateUpdate',
            'value' => Yii::createObject(Expression::class, ['NOW()']),
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%passkeys}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'administratorId', 'type'], 'required'],
            [['administratorId', 'counter'], 'integer'],
            [['name', 'credentialPublicKey', 'jsonData'], 'string'],
            [['dateCreate', 'dateUpdate'], 'safe'],
            [['id', 'type', 'attestationType', 'aaguid', 'userHandle'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['administratorId'], 'exist', 'skipOnError' => true, 'targetClass' => Administrator::class, 'targetAttribute' => ['administratorId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('models/passkey', 'Id'),
            'name' => Module::t('models/passkey', 'Name'),
            'administratorId' => Module::t('models/passkey', 'Administrator Id'),
            'type' => Module::t('models/passkey', 'Type'),
            'attestationType' => Module::t('models/passkey', 'Attestation Type'),
            'aaguid' => Module::t('models/passkey', 'Aaguid'),
            'credentialPublicKey' => Module::t('models/passkey', 'Credential Public Key'),
            'userHandle' => Module::t('models/passkey', 'User Handle'),
            'counter' => Module::t('models/passkey', 'Counter'),
            'jsonData' => Module::t('models/passkey', 'Json Data'),
            'dateCreate' => Module::t('models/passkey', 'Date Create'),
            'dateUpdate' => Module::t('models/passkey', 'Date Update'),
        ];
    }

    /**
     * Gets query for [[Administrator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrator()
    {
        return $this->hasOne(Administrator::class, ['id' => 'administratorId']);
    }
}
