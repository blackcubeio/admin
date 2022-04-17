<?php
/**
 * ToggleAction.php
 *
 * PHP version 7.4+
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
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class ToggleAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class ToggleAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '_line';

    /**
     * @var string
     */
    public $elementName = 'element';

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException(Module::t('actions', 'Property "elementClass" must be defined'));
        }
        $elementClass = $this->elementClass;
        $element = $elementClass::findOne(['id' => $id]);
        if ($element === null) {
            throw new NotFoundHttpException();
        }
        $element->active = !$element->active;
        if ($element instanceof ElementInterface && $element->slug !== null) {
            $element->slug->active = $element->active;
        }
        $transaction = Module::getInstance()->db->beginTransaction();
        try {
            $elementStatus = $element->save(false, ['active', 'dateUpdate']);
            if ($element instanceof ElementInterface) {
                if ($element->slug !== null) {
                    $slugStatus = $element->slug->save(false, ['active', 'dateUpdate']);
                } else {
                    $slugStatus = true;
                }
                if ($elementStatus && $slugStatus) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }
            } else {
                $transaction->commit();
            }
        } catch(\Exception $e) {
            $transaction->rollBack();
        }

        return $this->controller->renderPartial($this->view, [
            $this->elementName => $element
        ]);
    }
}
