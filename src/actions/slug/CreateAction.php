<?php
/**
 * CreateAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */

namespace blackcube\admin\actions\slug;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Tag as TagHelper;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Language;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */
class CreateAction extends BaseElementAction
{
    /**
     * @var string view
     */
    public $view = 'form';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'edit';

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $slug = Yii::createObject(Slug::class);
        $slug->setScenario(Slug::SCENARIO_REDIRECT);
        /* @var $slug Slug */

        if (Yii::$app->request->isPost) {
            $slug->load(Yii::$app->request->bodyParams);
            if ($slug->save()) {
                return $this->controller->redirect([$this->targetAction, 'id' => $slug->id]);
            }
        }

        return $this->controller->render($this->view, [
            'element' => $slug,

        ]);
    }
}
