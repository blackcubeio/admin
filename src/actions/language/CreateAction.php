<?php
/**
 * CreateAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\language
 */

namespace blackcube\admin\actions\language;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\Module;
use blackcube\core\models\Language;
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
 * @package blackcube\admin\actions\language
 */
class CreateAction extends BaseElementAction
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
     * @param Language $language
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Language $language)
    {
        if (Yii::$app->request->isPost) {
            $language->load(Yii::$app->request->bodyParams);
            $transaction = Module::getInstance()->db->beginTransaction();

            if ($language->save()) {
                $transaction->commit();
                return $this->controller->redirect([$this->targetAction, 'id' => $language->id]);
            }
            $transaction->rollBack();
        }

        return $this->controller->render($this->view, [
            'language' => $language,
        ]);
    }
}
