<?php
/**
 * EditAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */

namespace blackcube\admin\actions\plugin;

use blackcube\core\models\Plugin;
use yii\base\Action;
use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\Module;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */
class EditAction extends Action
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
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $plugin = Plugin::find()->andWhere(['id' => $id])->one();
        if ($plugin === null) {
            throw new NotFoundHttpException();
        }

        if (Yii::$app->request->isPost) {
            $plugin->load(Yii::$app->request->bodyParams);
            if ($plugin->save() === true) {
                return $this->controller->redirect([$this->targetAction, 'id' => $plugin->id]);
            }
        }

        return $this->controller->render($this->view, [
            'plugin' => $plugin,
        ]);
    }
}
