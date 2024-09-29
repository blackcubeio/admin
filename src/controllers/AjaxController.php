<?php
/**
 * AjaxController.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\passkey\PrepareAttachDevice;
use blackcube\admin\actions\passkey\PrepareLogin;
use blackcube\admin\actions\passkey\PrepareLoginDevice;
use blackcube\admin\actions\passkey\PrepareRegisterDevice;
use blackcube\admin\actions\passkey\ValidateLogin;
use blackcube\admin\actions\passkey\ValidateRegister;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Html;
use blackcube\admin\Module;
use blackcube\core\components\Element;
use blackcube\core\components\RouteEncoder;
use blackcube\core\interfaces\PreviewManagerInterface;
use blackcube\core\interfaces\SlugGeneratorInterface;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class AjaxController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class AjaxController extends Controller
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        $actions = parent::actions();
        $actions['prepare-attach-device'] = PrepareAttachDevice::class;
        // $actions['prepare-register-device'] = PrepareRegisterDevice::class;
        $actions['validate-register'] = ValidateRegister::class;
        $actions['prepare-login'] = PrepareLogin::class;
        $actions['prepare-login-device'] = PrepareLoginDevice::class;
        $actions['validate-login'] = ValidateLogin::class;
        return $actions;
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'preview'
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_PREVIEW]
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'generate-slug',
                        'prepare-attach-device',
                        'validate-register',
                    ],
                    'roles' => ['@']
                ],
                [
                    'allow' => true,
                    'actions' => [
                        // not allowed to register with a device
                        // 'prepare-register-device',
                        // 'validate-register',
                        'prepare-login',
                        'prepare-login-device',
                        'validate-login',
                    ],
                    'roles' => ['?']
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => [
                'preview',
                'prepare-attach-device',
                // 'prepare-register-device',
                'validate-register',
                'prepare-login',
                'prepare-login-device',
                'validate-login'
            ],
        ];

        return $behaviors;
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPreview(PreviewManagerInterface $previewManager)
    {
        if ($previewManager->check() === true) {
            $previewManager->deactivate();
        } else {
            $previewManager->activate();
        }
        $content = Html::tag('span', Module::t('widgets', 'Preview'), ['class' => 'sr-only']);
        $content .= "\n" . Heroicons::svg(
    $previewManager->check() ? 'outline/eye' : 'outline/eye-off',
            ['class' => 'preview-icon']);

        return $content;
    }

    public function actionGenerateSlug(SlugGeneratorInterface $slugGenerator)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost === true) {
            $parameters = Yii::$app->request->bodyParams;
        } elseif (Yii::$app->request->isGet === true) {
            $parameters = Yii::$app->request->queryParams;
        }
        if (isset($parameters['id']) && isset($parameters['type'])) {
            $route = RouteEncoder::encode($parameters['type'], $parameters['id']);
            $element = Element::instanciate($route);
            if ($element !== null) {
                $slug = $slugGenerator->getElementSlug($element, true);
                return [
                    'elementType' => $parameters['type'],
                    'elementId' => $parameters['id'],
                    'url' => $slug
                ];
            }
        }

        throw new UnprocessableEntityHttpException();

    }
}
