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

use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Html;
use blackcube\admin\models\SlugGeneratorForm;
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
                        'generate-slug'
                    ],
                    'roles' => ['@']
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['preview'],
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
