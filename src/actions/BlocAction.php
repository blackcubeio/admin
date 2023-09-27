<?php
/**
 * BlocAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */

namespace blackcube\admin\actions;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class BlocAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class BlocAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_blocs';

    /**
     * @param null $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException(Module::t('actions', 'Property "elementClass" must be defined'));
        }
        $elementClass = $this->elementClass;
        if ($id !== null) {
            /** @var Node|Composite|Category|Tag $element */
            $element = $elementClass::findOne(['id' => $id]);
            if ($element === null) {
                throw new NotFoundHttpException();
            }
        } else {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {

            $originalBlocs = $element->getBlocs()->all();
            Model::loadMultiple($originalBlocs, Yii::$app->request->bodyParams);
            if (isset(Yii::$app->request->bodyParams['blocAdd'])) {
                $bloc = Yii::createObject(Bloc::class);
                $bloc->blocTypeId = Yii::$app->request->bodyParams['blocTypeId'];
                $bloc->save(false);
                $element->attachBloc($bloc, -1);
                $blocId = Yii::$app->request->bodyParams['blocAdd'];
                $blocId = (int) $blocId;
                if ($blocId > 0) {
                    $previousBloc = Bloc::find()->andWhere(['id' => $blocId])->one();
                    if ($previousBloc !== null) {
                        /** @var Bloc $previousBloc */
                        foreach($element->getBlocs()->each() as $idx => $attachedBloc) {
                            if ($attachedBloc->id == $previousBloc->id) {
                                $element->moveBloc($bloc, $idx + 2);
                                break;
                            }
                        }
                        // $element->moveBloc($bloc, $previousBloc);
                    }
                }
                // $element->moveBloc($bloc, Yii::$app->request->bodyParams['blocAdd']);
            } elseif (isset(Yii::$app->request->bodyParams['blocDelete'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocDelete']])->one();
                if ($bloc !== null) {
                    $element->detachBloc($bloc);
                }
            } elseif (isset(Yii::$app->request->bodyParams['blocUp'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocUp']])->one();
                if ($bloc !== null) {
                    $element->moveBlocUp($bloc);
                }
            } elseif (isset(Yii::$app->request->bodyParams['blocDown'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocDown']])->one();
                if ($bloc !== null) {
                    $element->moveBlocDown($bloc);
                }
            }
            $blocs = $element->getBlocs()->all();
            foreach($blocs as $bloc) {
                foreach ($originalBlocs as $originalBloc) {
                    if ($bloc->id == $originalBloc->id) {
                        $bloc->attributes = $originalBloc->attributes;
                        break;
                    }
                }
            }
        } else {
            $blocs = $element->getBlocs()->all();
        }
        return $this->controller->renderPartial($this->view, ['blocs' => $blocs, 'element' => $element]);

    }
}
