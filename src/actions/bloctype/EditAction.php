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
 * @package blackcube\admin\actions\bloctype
 */

namespace blackcube\admin\actions\bloctype;

use blackcube\admin\helpers\Type as TypeHelper;
use blackcube\core\models\BlocType;
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
 * @package blackcube\admin\actions\bloctype
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
        $blocType = BlocType::findOne(['id' => $id]);
        if ($blocType === null) {
            throw new NotFoundHttpException();
        }
        $typeBlocTypes = TypeHelper::getTypeBlocTypes($id);
        if (Yii::$app->request->isPost) {
            $blocType->load(Yii::$app->request->bodyParams);
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($blocType->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                if ($blocType->save()) {
                    foreach($typeBlocTypes as $typeBlocType) {
                        $typeBlocType->save();
                    }
                    return $this->controller->redirect([$this->targetAction, 'id' => $blocType->id]);
                }
            }
        }
        return $this->controller->render($this->view, [
            'blocType' => $blocType,
            'typeBlocTypes' => $typeBlocTypes,
        ]);
    }
}
