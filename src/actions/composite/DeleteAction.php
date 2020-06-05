<?php
/**
 * DeleteAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\Module;
use blackcube\core\models\Composite;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
 */
class DeleteAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

    /**
     * @var callable
     */
    public $compositeQuery;

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $compositeQuery = null;
        if (is_callable($this->compositeQuery) === true) {
            $compositeQuery = call_user_func($this->compositeQuery);
        }
        if ($compositeQuery === null || (($compositeQuery instanceof ActiveQuery) === false)) {
            $compositeQuery = Composite::find();
        }
        $composite = $compositeQuery->andWhere(['id' => $id])->one();

        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $composite->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $composite->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $composite->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
