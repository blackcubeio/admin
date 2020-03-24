<?php
/**
 * Administrator.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%administrators}}".
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 *
 * @property int $id
 * @property string $email
 * @property string|null $password
 * @property boolean $active
 * @property string|null $authKey
 * @property string|null $token
 * @property string|null $tokenType
 * @property string $dateCreate
 * @property string|null $dateUpdate
 */
class Administrator extends \yii\db\ActiveRecord implements IdentityInterface
{
    public const SCENARIO_LOGIN = 'login';
    public const SCENARIO_CREATE = 'create';
    /**
     * {@inheritdoc}
     */
    public function behaviors():array
    {
        $behaviors = parent::behaviors();
        $behaviors['timestamp'] = [
            'class' => TimestampBehavior::class,
            'createdAtAttribute' => 'dateCreate',
            'updatedAtAttribute' => 'dateUpdate',
            'value' => new Expression('NOW()'),
        ];
        return $behaviors;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName():string
    {
        return '{{%administrators}}';
    }

    /**
     * {@inheritdoc}
     * Add FilterActiveQuery
     * @return FilterActiveQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new FilterActiveQuery(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_LOGIN] = ['email', 'password'];
        $scenarios[static::SCENARIO_CREATE] = ['email', 'password'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['password'], 'required', 'on' => [static::SCENARIO_LOGIN, static::SCENARIO_CREATE]],
            [['email'], 'unique', 'on' => [static::SCENARIO_CREATE]],
            [['active'], 'boolean'],
            [['dateCreate', 'dateUpdate'], 'safe'],
            [['email', 'password', 'authKey', 'token', 'tokenType'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels():array
    {
        return [
            'id' => Yii::t('blackcube.admin', 'ID'),
            'email' => Yii::t('blackcube.admin', 'Email'),
            'password' => Yii::t('blackcube.admin', 'Password'),
            'active' => Yii::t('blackcube.admin', 'Active'),
            'authKey' => Yii::t('blackcube.admin', 'Auth Key'),
            'token' => Yii::t('blackcube.admin', 'Token'),
            'tokenType' => Yii::t('blackcube.admin', 'Token Type'),
            'dateCreate' => Yii::t('blackcube.admin', 'Date Create'),
            'dateUpdate' => Yii::t('blackcube.admin', 'Date Update'),
        ];
    }

    /**
     * Validate login
     *
     * @param $attribute
     * @param $params
     *
     * @since  XXX
     */
    public function validateLogin($attribute, $params)
    {
        $administrator = static::find()->where(['email' => $this->$attribute])->active()->one();
        if ($administrator !== null) {
            $password = $this->password;
            if (static::validatePassword($password, $administrator->password) === false) {
                $this->addError('password', Yii::t('blackcube.admin', 'Password is invalid'));
                $success = false;
            }
        } else {
            $this->addError($attribute, Yii::t('blackcube.admin', 'Administrator does not exist'));
            $success = false;
        }

        return $success;
    }

    /**
     * @param string $password password to check
     * @param string $hash hashed password sotred in db
     * @return bool
     */
    public static function validatePassword($password, $hash)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $hash);
    }

    /**
     * @param string $password
     * @return string hashed password
     * @throws \yii\base\Exception
     */
    public static function hashPassword($password)
    {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }


    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentity($id)
    {
        return static::find()->where(['id' => $id])->one();
    }

    /**
     * {@inheritDoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritDoc}
     */
    public function validateAuthKey($authKey)
    {
        return empty($this->authKey) === false && $this->authKey === $authKey;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave($insert)
    {
        //TODO: better check with password_get_info($this->password) => ['algoName' => 'unknown'] not hashed;
        if ($this->scenario === static::SCENARIO_CREATE) {
            $this->password = static::hashPassword($this->password);
        }
        if (empty($this->authKey) === true) {
            $this->authKey = Yii::$app->getSecurity()->generateRandomString();
        }
        return parent::beforeSave($insert);
    }
}
