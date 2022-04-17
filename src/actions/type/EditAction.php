<?php
/**
 * EditAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\type
 */

namespace blackcube\admin\actions\type;

use blackcube\admin\helpers\BlocType as BlocTypeHelper;
use blackcube\admin\helpers\Route as RouteHelper;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\base\Model;
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
 * @package blackcube\admin\actions\type
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
        $type = Type::findOne(['id' => $id]);
        if ($type === null) {
            throw new NotFoundHttpException();
        }
        $typeBlocTypes = BlocTypeHelper::getTypeBlocTypes($id);
        if (Yii::$app->request->isPost) {
            $type->load(Yii::$app->request->bodyParams);
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($type->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                if ($type->save()) {
                    foreach ($typeBlocTypes as $typeBlocType) {
                        $typeBlocType->save();
                    }
                    return $this->controller->redirect([$this->targetAction, 'id' => $type->id]);
                }
            }
        }
        return $this->controller->render($this->view, [
            'type' => $type,
            'typeBlocTypes' => $typeBlocTypes,
            'routes' => RouteHelper::findRoutes(),
        ]);
    }
}
