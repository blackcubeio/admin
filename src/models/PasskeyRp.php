<?php

namespace blackcube\admin\models;

use blackcube\admin\Module;
use Webauthn\PublicKeyCredentialRpEntity;

class PasskeyRp extends \yii\base\Model
{
    public $id;
    public $name;
    public $icon;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'filter', 'filter' => function ($value) {
                return empty($value) ? \Yii::$app->request->hostName : $value;
            }],
            [['name'], 'filter', 'filter' => function ($value) {
                return empty($value) ? \Yii::$app->name : $value;
            }],
            [['icon'], 'filter', 'filter' => function ($value) {
                return empty($value) ? null : $value;
            }],
            [['id', 'name'], 'required'],
            [['id', 'name', 'icon'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('models/passkeyRp', 'ID'),
            'name' => Module::t('models/passkeyRp', 'Name'),
            'icon' => Module::t('models/passkeyRp', 'Icon'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPublicKeyCredentialRpEntity(): PublicKeyCredentialRpEntity
    {
        if (!$this->validate()) {
            throw new \Exception('Invalid data');
        }
        return PublicKeyCredentialRpEntity::create($this->name, $this->id, $this->icon);
    }
}