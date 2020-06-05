<?php
/**
 * ToggleAction.php
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

use blackcube\admin\Module;
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ToggleAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */
class ToggleAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $view = '_line';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        if ($id !== null) {
            $currentSlug = Slug::findOne(['id' => $id]);
            if ($currentSlug !== null) {
                $currentSlug->active = !$currentSlug->active;
                if ($currentSlug->element !== null) {
                    $currentSlug->element->active = $currentSlug->active;
                }
                $transaction = Module::getInstance()->db->beginTransaction();
                try {
                    $slugStatus = $currentSlug->save(false, ['active', 'dateUpdate']);
                    if ($currentSlug->element !== null) {
                        $elementStatus = $currentSlug->element->save(false, ['active', 'dateUpdate']);
                    } else {
                        $elementStatus = true;
                    }
                    if ($slugStatus && $elementStatus) {
                        $transaction->commit();
                    } else {
                        $transaction->rollBack();
                    }
                } catch(\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->controller->renderPartial($this->view, [
            'slug' => $currentSlug
        ]);
    }
}
