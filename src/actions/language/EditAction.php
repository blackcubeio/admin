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

namespace blackcube\admin\actions\language;

use blackcube\admin\Module;
use blackcube\core\models\Language;
use yii\base\Action;
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
        $language = Language::find()
            ->andWhere(['id' => $id])
            ->one();
        /* @var $language Language */

        if ($language === null) {
            throw new NotFoundHttpException();
        };

        if (Yii::$app->request->isPost) {
            $language->load(Yii::$app->request->bodyParams);
            $transaction = Module::getInstance()->get('db')->beginTransaction();
            if ($language->save() === true) {
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
