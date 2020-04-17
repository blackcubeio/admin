<?php
/**
 * Module.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin
 */

namespace blackcube\admin;

use blackcube\admin\commands\AdministratorController;
use blackcube\admin\commands\IconsController;
use blackcube\admin\commands\InitController;
use blackcube\admin\models\Administrator;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\console\controllers\MigrateController;
use yii\db\Connection;
use yii\di\Instance;
use yii\i18n\GettextMessageSource;
use yii\rbac\DbManager;
use yii\web\Application as WebApplication;
use yii\web\User as WebUser;
use yii\console\Application as ConsoleApplication;
use Yii;

/**
 * Class module
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin
 */
class Module extends BaseModule implements BootstrapInterface
{

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'blackcube\admin\controllers';

    /**
     * @var string alias of the directory where we can find bloc templates for admin display
     */
    public $adminTemplatesAlias;

    /**
     * @var Connection|array|string database access
     */
    public $db = 'db';

    /**
     * @var string command prefix
     */
    public $commandNameSpace = 'bca:';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
        $this->registerTranslations();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@blackcube/admin', __DIR__);
        $app->setComponents([
            'authManager' => [
                'class' => DbManager::class,
                'db' => $this->db,
            ]
        ]);
        if ($app instanceof ConsoleApplication) {
            $this->bootstrapConsole($app);
        } elseif ($app instanceof WebApplication) {
            $this->bootstrapWeb($app);
        }
    }

    /**
     * Bootstrap console stuff
     *
     * @param ConsoleApplication $app
     * @since XXX
     */
    protected function bootstrapConsole(ConsoleApplication $app)
    {
        $app->controllerMap[$this->commandNameSpace.'admin'] = [
            'class' => AdministratorController::class,
        ];
        $app->controllerMap[$this->commandNameSpace.'init'] = [
            'class' => InitController::class,
        ];
        $app->controllerMap[$this->commandNameSpace.'migrate'] = [
            'class' => MigrateController::class,
            'migrationNamespaces' => [
                'blackcube\admin\migrations',
            ],
            'migrationPath' => [
                '@yii/rbac/migrations',
            ],
            'db' => $this->db,
        ];

    }

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    protected function bootstrapWeb(WebApplication $app)
    {
        $app->setComponents([
            'user' => [
                'class' => WebUser::class,
                'identityClass' => Administrator::class,
                'enableAutoLogin' => true,
                'autoRenewCookie' => true,
                'loginUrl' => ['admin/authentication/login'],
                'idParam' => '__blackcubeId',
                'returnUrlParam' => '__blackcubeReturnUrl',
                'identityCookie' => [
                    'name' => '_blackcubeIdentity', 'httpOnly' => true
                ]
            ]
        ]);

    }

    /**
     * Register translation stuff
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['blackcube/admin/*'] = [
            'class' => GettextMessageSource::class,
            'sourceLanguage' => 'en',
            'useMoFile' => false,
            'basePath' => '@blackcube/admin/i18n',
        ];
    }

    /**
     * Translates a message to the specified language.
     *
     * This is a shortcut method of [[\yii\i18n\I18N::translate()]].
     *
     * The translation will be conducted according to the message category and the target language will be used.
     *
     * You can add parameters to a translation message that will be substituted with the corresponding value after
     * translation. The format for this is to use curly brackets around the parameter name as you can see in the following example:
     *
     * ```php
     * $username = 'Alexander';
     * echo Module::t('app', 'Hello, {username}!', ['username' => $username]);
     * ```
     *
     * Further formatting of message parameters is supported using the [PHP intl extensions](https://secure.php.net/manual/en/intro.intl.php)
     * message formatter. See [[\yii\i18n\I18N::translate()]] for more details.
     *
     * @param string $category the message category.
     * @param string $message the message to be translated.
     * @param array $params the parameters that will be used to replace the corresponding placeholders in the message.
     * @param string $language the language code (e.g. `en-US`, `en`). If this is null, the current
     * [[\yii\base\Application::language|application language]] will be used.
     * @return string the translated message.
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('blackcube/admin/' . $category, $message, $params, $language);
    }
}
