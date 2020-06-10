<?php
/**
 * EditAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */

namespace blackcube\admin\actions\slug;

use blackcube\admin\models\SlugForm;
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
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
        $slug = Slug::findOne(['id' => $id]);
        if ($slug === null) {
            throw new NotFoundHttpException();
        }
        if ($slug->element === null) {
            $slug->setScenario(Slug::SCENARIO_REDIRECT);
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $slug,
        ]);

        if (Yii::$app->request->isPost) {
            $slugForm->multiLoad(Yii::$app->request->bodyParams);
            if ($slugForm->preValidate()) {
                if ($slugForm->save()) {
                    return $this->controller->redirect([$this->targetAction, 'id' => $slug->id]);
                }
            }
        }
        return $this->controller->render($this->view, [
            'slugForm' => $slugForm,
        ]);
    }
}
