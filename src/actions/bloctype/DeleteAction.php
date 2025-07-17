<?php
/**
 * DeleteAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\bloctype;

use blackcube\core\models\BlocType;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
     * @throws \yii\base\InvalidConfigException|\yii\db\StaleObjectException
     */
    public function run($id)
    {
        $blocType = BlocType::findOne(['id' => $id]);
        if ($blocType === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $blocType->delete();
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
