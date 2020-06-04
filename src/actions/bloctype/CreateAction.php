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
 * @package blackcube\admin\actions\bloctype
 */

namespace blackcube\admin\actions\bloctype;

use blackcube\admin\Module;
use blackcube\core\models\BlocType;
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
 * @package blackcube\admin\actions\bloctype
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
        $blocType = Yii::createObject(BlocType::class);
        $blocType->template = '{"type": "object", "properties": {"text": {"type": "string"}}, "required": []}';
        $typeBlocTypes = $this->getTypeBlocTypes();
        if (Yii::$app->request->isPost) {
            $blocType->load(Yii::$app->request->bodyParams);
            foreach($typeBlocTypes as $typeBlocType) {
                $typeBlocType->setScenario(TypeBlocType::SCENARIO_PRE_VALIDATE_TYPE);
            }
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($blocType->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                try {
                    if ($blocType->save()) {
                        foreach($typeBlocTypes as $typeBlocType) {
                            $typeBlocType->blocTypeId = $blocType->id;
                            $typeBlocType->save();
                        }
                        $transaction->commit();
                        return $this->controller->redirect([$this->targetAction]);
                    }
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->controller->render($this->view, [
            'blocType' => $blocType,
            'typeBlocTypes' => $typeBlocTypes,
        ]);
    }
}
