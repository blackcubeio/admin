<?php
/**
 * EditAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
