<?php
/**
 * Administrator.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 *
 * @property int $id
 * @property string $email
 * @property string $firstname
 * @property string $lastname
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
    public const SCENARIO_CREATE_ONLINE = 'create_online';
    public const SCENARIO_UPDATE = 'update';

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $checkPassword;

    /**
     * @var bool
     */
    public $rememberMe;

    /**
     * {@inheritDoc}
     */
    public static function getDb()
    {
        return Module::getInstance()->get('db');
    }

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
    public static function tableName() :string
    {
        return '{{%administrators}}';
    }

    /**
     * {@inheritdoc}
     * Add FilterActiveQuery
     * @return FilterActiveQuery|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
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
        $scenarios[static::SCENARIO_LOGIN] = ['email', 'password', 'rememberMe'];
        $scenarios[static::SCENARIO_CREATE] = ['email', 'firstname', 'lastname', 'password'];
        $scenarios[static::SCENARIO_CREATE_ONLINE] = ['email', 'firstname', 'lastname', 'newPassword', 'checkPassword', 'active'];
        $scenarios[static::SCENARIO_UPDATE] = ['email', 'firstname', 'lastname', 'newPassword', 'checkPassword', 'active'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() :array
    {
        return [
            [['email', 'firstname', 'lastname'], 'required'],
            [['email'], 'email'],
            [['password'], 'required', 'on' => [static::SCENARIO_LOGIN, static::SCENARIO_CREATE]],
            [['newPassword', 'checkPassword'], 'required', 'on' => [static::SCENARIO_CREATE_ONLINE]],
            [['newPassword'], 'compare', 'compareAttribute' => 'checkPassword', 'on' => [static::SCENARIO_UPDATE, static::SCENARIO_CREATE_ONLINE]],
            [['newPassword'], 'passwordSecurity', 'usernameAttribute' => 'email', 'on' => [static::SCENARIO_CREATE_ONLINE, static::SCENARIO_UPDATE]],
            [['email'], 'validateLogin', 'on' => [static::SCENARIO_LOGIN], 'params' => ['password' => 'password']],
            [['email'], 'unique', 'on' => [static::SCENARIO_CREATE, static::SCENARIO_CREATE_ONLINE, static::SCENARIO_UPDATE]],
            [['active'], 'boolean'],
            [['dateCreate', 'dateUpdate'], 'safe'],
            [['email', 'firstname', 'lastname', 'password', 'authKey', 'token', 'tokenType'], 'string', 'max' => 190],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() :array
    {
        return [
            'id' => Module::t('models', 'ID'),
            'email' => Module::t('models', 'E-mail'),
            'firstname' => Module::t('models', 'Firstname'),
            'lastname' => Module::t('models', 'Lastname'),
            'password' => Module::t('models', 'Password'),
            'newPassword' => Module::t('models', 'New Password'),
            'checkPassword' => Module::t('models', 'Password Verification'),
            'rememberMe' => Module::t('models', 'Remember me'),
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
     * @param string $attribute
     * @param array $params
     * @throws \yii\base\InvalidConfigException
     */
    public function validateLogin($attribute, $params)
    {
        $administrator = static::find()
            ->where(['email' => $this->$attribute])
            ->active()
            ->one();
        if ($administrator !== null) {
            $password = $this->{$params['password']};
            //$administrator->validatePassword($password);
            try {
                if ($administrator->validatePassword($password) === false) {
                    $this->addError('password', Module::t('validators', 'Password is invalid'));
                }
            } catch(\Exception $e) {
                $this->addError('email', Module::t('validators', 'User is invalid'));
            }
        } else {
            $this->addError($attribute, Module::t('validators', 'Administrator does not exist'));
        }
    }

    /**
     * @param string $password password to check
     * @return bool
     */
    public function validatePassword($password)
    {
        try {
            return Yii::$app->getSecurity()->validatePassword($password, $this->password);
        } catch(\Exception $e) {
            return false;
        }
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

    public function getInitials()
    {
        return ($this->firstname[0]??'X').($this->lastname[0]??'X');
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
        return static::find()
            ->where(['id' => $id])
            ->active()
            ->one();
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
        if (empty($this->password) === false) {
            $passwordInfo = password_get_info($this->password);
            if ($passwordInfo['algoName'] === 'unknown') {
                $this->password = static::hashPassword($this->password);
            }
        }
        if (empty($this->authKey) === true) {
            $this->authKey = Yii::$app->getSecurity()->generateRandomString();
        }
        return parent::beforeSave($insert);
    }
}
