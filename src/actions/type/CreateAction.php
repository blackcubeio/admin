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
 * @package blackcube\admin\actions\type
 */

namespace blackcube\admin\actions\type;

use blackcube\admin\Module;
use blackcube\core\models\Type;
use blackcube\admin\helpers\BlocType as BlocTypeHelper;
use blackcube\admin\helpers\Route as RouteHelper;
use blackcube\core\models\TypeBlocType;
use yii\base\Action;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\type
 */
class CreateAction extends Action
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
        $type = Yii::createObject(Type::class);
        $typeBlocTypes = BlocTypeHelper::getTypeBlocTypes();
        if (Yii::$app->request->isPost) {
            $type->load(Yii::$app->request->bodyParams);
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($type->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                try {
                    $typeStatus = $type->save();
                    if ($typeStatus === true) {
                        $status = true;
                        foreach ($typeBlocTypes as $typeBlocType) {
                            /* @var $typeBlocType \blackcube\core\models\TypeBlocType */
                            $typeBlocType->setScenario(TypeBlocType::SCENARIO_DEFAULT);
                            $typeBlocType->typeId = $type->id;
                            $status = $status && $typeBlocType->save();
                        }
                        if ($typeStatus && $status) {
                            $transaction->commit();
                            return $this->controller->redirect([$this->targetAction, 'id' => $type->id]);
                        }
                    }
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
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
