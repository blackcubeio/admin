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

namespace blackcube\admin\actions\passkey;

use blackcube\admin\models\Administrator;
use blackcube\admin\models\Passkey;
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
    public $targetAction = 'account';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $administrator = Yii::$app->user->identity;
        /* @var Administrator $administrator */
        $passkey = $administrator->getPasskeys()->andWhere(['id' => $id])->one();
        if ($passkey === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $passkey->delete();
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
