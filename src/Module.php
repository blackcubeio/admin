<?php
/**
 * Module.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin
 */

namespace blackcube\admin;

use blackcube\admin\commands\AdministratorController;
use blackcube\admin\commands\HeroiconsController;
use blackcube\admin\commands\RbacController;
use blackcube\admin\interfaces\MigrableInterface;
use blackcube\admin\interfaces\PluginManagerBootstrapInterface;
use blackcube\admin\models\Administrator;
use blackcube\admin\models\FilterActiveQuery;
use blackcube\admin\models\MoveNodeForm;
use blackcube\admin\models\RbacItemForm;
use blackcube\admin\models\SearchForm;
use blackcube\admin\models\SlugGeneratorForm;
use blackcube\admin\models\TagForm;
use blackcube\core\components\PreviewManager;
use blackcube\core\interfaces\PluginsHandlerInterface;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\caching\CacheInterface;
use yii\console\controllers\MigrateController;
use yii\db\Connection;
use yii\di\Instance;
use yii\i18n\GettextMessageSource;
use yii\rbac\DbManager;
use yii\web\Application as WebApplication;
use yii\web\ErrorHandler;
use yii\web\User as WebUser;
use yii\web\UrlRule;
use yii\web\GroupUrlRule;
use yii\console\Application as ConsoleApplication;
use Yii;

/**
 * Class module
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin
 *
 * @var $blackcubeUser WebUser
 */
class Module extends BaseModule implements BootstrapInterface
{

    /**
     * {@inheritDoc}
     */
    public $defaultRoute = 'dashboard';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'blackcube\admin\controllers';

    /**
     * @var string alias of the directory where we can find bloc templates for admin display
     */
    public $adminTemplatesAlias;

    /**
     * @var string command prefix
     */
    public $commandNameSpace = 'bc:';

    /**
     * @var array list off assets to add to the admin page
     * ['\app\assets\StaticAsset', '\app\assets\OtherAsset' => ['blocTypeId', 'otherBlockTypeId']
     * in this case, StaticAsset will be registered in all pages while OtherAsset will be only registered when blocTypeId and otherBlocTypeId can be used
     */
    public $additionalAssets = [];

    /**
     * @var string version number
     */
    public $version = 'v3.0.4';

    /**
     * @var string[]
     */
    public $coreSingletons = [
    ];

    /**
     * @var string[]
     */
    public $coreElements = [
        Administrator::class => Administrator::class,
        FilterActiveQuery::class => FilterActiveQuery::class,
        MoveNodeForm::class => MoveNodeForm::class,
        RbacItemForm::class => RbacItemForm::class,
        SearchForm::class => SearchForm::class,
        SlugGeneratorForm::class => SlugGeneratorForm::class,
        TagForm::class => TagForm::class,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();
        //TODO: should inherit db from Core
        $this->registerErrorHandler();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@blackcube/admin', __DIR__);
        $this->registerDi($app);
        $app->setComponents([
            'authManager' => [
                'class' => DbManager::class,
                'db' => $this->get('db'),
                'cache' => $this->get('cache'),
            ],
        ]);
        $this->registerTranslations();
        if ($app instanceof ConsoleApplication) {
            $this->bootstrapConsole($app);
        } elseif ($app instanceof WebApplication) {
            $this->bootstrapWeb($app);
        }
        $this->registerPlugins($app);
        if ($app instanceof WebApplication) {
            $this->finalizeBbootstrapWeb($app);
        }
    }

    /**
     * @param WebApplication|ConsoleApplication $app
     * @throws \yii\base\InvalidConfigException
     */
    public function registerDi($app)
    {
        foreach($this->coreSingletons as $class => $definition) {
            if (Yii::$container->hasSingleton($class) === false) {
                Yii::$container->setSingleton($class, $definition);
            }
        }
        foreach($this->coreElements as $class => $definition) {
            if (Yii::$container->has($class) === false) {
                Yii::$container->set($class, $definition);
            }
        }
    }
    public function registerPlugins($app)
    {
        if ($app instanceof WebApplication) {
            $pluginHandler = Yii::createObject(PluginsHandlerInterface::class);
            /* @var $pluginHandler PluginsHandlerInterface */
            foreach ($pluginHandler->getRegisteredPluginManagers() as $pluginManager) {
                // foreach($pluginHandler->getActivePluginManagers() as $pluginManager) {
                if ($pluginManager instanceof PluginManagerBootstrapInterface) {
                    $pluginManager->bootstrapAdmin($this, $app);
                }
            }
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
        $app->controllerMap[$this->commandNameSpace.'rbac'] = [
            'class' => RbacController::class,
        ];
        if (defined('YII_ENV') && YII_ENV === 'dev') {
            $app->controllerMap[$this->commandNameSpace.'heroicons'] = [
                'class' => HeroiconsController::class,
            ];
        }

        // TODO check what to do if db is not the same as the base app one
        $migrationNamespaces = $this->buildMigrationNamespaces();
        if (isset($app->controllerMap['migrate']) === true) {
            if (isset($app->controllerMap['migrate']['migrationNamespaces']) === true) {
                foreach ($migrationNamespaces as $migrationNamespace) {
                    $app->controllerMap['migrate']['migrationNamespaces'][] = $migrationNamespace;
                }
            } else {
                $app->controllerMap['migrate']['migrationNamespaces'] = $migrationNamespaces;
            }
            if (isset($app->controllerMap['migrate']['migrationPath']) === true) {
                $app->controllerMap['migrate']['migrationPath'][] = '@yii/rbac/migrations';
            } else {
                $app->controllerMap['migrate']['migrationPath'] = [
                    '@yii/rbac/migrations',
                ];
            }
        } else {
            $app->controllerMap['migrate'] = [
                'class' => MigrateController::class,
                'migrationNamespaces' => $migrationNamespaces,
                'migrationPath' => [
                    '@yii/rbac/migrations',
                ],
                'db' => $this->get('db'),
            ];
        }
        /**/

    }

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    protected function bootstrapWeb(WebApplication $app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => GroupUrlRule::class,
                'prefix' => $this->id,
                'rules' => [
                    ['class' => UrlRule::class, 'pattern' => '', 'route' => 'dashboard/index'],
                    ['class' => UrlRule::class, 'pattern' => '<controller:[\w\-]+>', 'route' => '<controller>'],
                    ['class' => UrlRule::class, 'pattern' => '<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => '<controller>/<action>'],
                ],
            ]
        ], true);

    }
    /**
     * Finalize Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    protected function finalizeBbootstrapWeb(WebApplication $app)
    {
        list($route,) = $app->urlManager->parseRequest($app->request);
        if ($route !== null && preg_match('#'.$this->uniqueId.'/#', $route) > 0) {
            $app->setComponents([
                'user' => [
                    'class' => WebUser::class,
                    'identityClass' => Administrator::class,
                    'enableAutoLogin' => true,
                    'autoRenewCookie' => true,
                    'loginUrl' => [$this->uniqueId.'/authentication/login'],
                    'idParam' => '__blackcubeId',
                    'returnUrlParam' => '__blackcubeReturnUrl',
                    'identityCookie' => [
                        'name' => '_blackcubeIdentity', 'httpOnly' => true
                    ]
                ],
            ]);
        }
    }

    /**
     * Register translation stuff
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['blackcube/admin/*'] = [
            'class' => GettextMessageSource::class,
            'sourceLanguage' => 'en',
            'useMoFile' => true,
            'basePath' => '@blackcube/admin/i18n',
        ];
    }

    /**
     * Register errorHandler for all module URLs
     * @throws \yii\base\InvalidConfigException
     */
    public function registerErrorHandler()
    {
        if (Yii::$app instanceof WebApplication) {
            list($route,) = Yii::$app->urlManager->parseRequest(Yii::$app->request);
            if ($route !== null && preg_match('#'.$this->uniqueId.'/#', $route) > 0) {
                Yii::configure($this, [
                    'components' => [
                        'errorHandler' => [
                            'class' => ErrorHandler::class,
                            'errorAction' => $this->uniqueId.'/technical/error',
                        ]
                    ],
                ]);
                /** @var ErrorHandler $handler */
                $handler = $this->get('errorHandler');
                Yii::$app->set('errorHandler', $handler);
                $handler->register();
            }
        }
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

    /**
     * @return array migration namespaces
     */
    protected function buildMigrationNamespaces()
    {
        $modules = static::getInstance()->getModules();
        $migrationNamespaces = [
            'blackcube\admin\migrations',
        ];
        foreach($modules as $id => $module) {
            if (is_array($module) === true) {
                $moduleClass = $module['class'];
            } else {
                $moduleClass = get_class($module);
            }
            if (is_subclass_of($moduleClass, MigrableInterface::class) === true) {
                $namespaces = $moduleClass::getMigrationNamespaces();
                if (is_string($namespaces) === true) {
                    $namespaces = [$namespaces];
                }
                $migrationNamespaces = array_merge($migrationNamespaces, $namespaces);
            }
        }
        return $migrationNamespaces;
    }
}
