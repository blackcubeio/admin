<?php
/**
 * DeleteAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\models\Administrator;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */
class DeleteAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $user = Administrator::findOne(['id' => $id]);
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            Yii::$app->authManager->revokeAll($user->id);
            $user->delete();
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
