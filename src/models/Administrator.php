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

use blackcube\admin\Module;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;
use Yii;

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
            'value' => Yii::createObject(Expression::class, ['NOW()']),
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
        return Yii::createObject(FilterActiveQuery::class, [static::class]);
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
            'id' => Module::t('models', 'ID'),
            'email' => Module::t('models', 'Email'),
            'password' => Module::t('models', 'Password'),
            'active' => Module::t('models', 'Active'),
            'authKey' => Module::t('models', 'Auth Key'),
            'token' => Module::t('models', 'Token'),
            'tokenType' => Module::t('models', 'Token Type'),
            'dateCreate' => Module::t('models', 'Date Create'),
            'dateUpdate' => Module::t('models', 'Date Update'),
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
                $this->addError('password', Module::t('validators', 'Password is invalid'));
                $success = false;
            }
        } else {
            $this->addError($attribute, Module::t('validators', 'Administrator does not exist'));
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
