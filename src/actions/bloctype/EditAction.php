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
