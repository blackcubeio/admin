<?php
/**
 * ModalAction.php
 *
 * PHP version 7.2+
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
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ModalAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class ModalAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_modal';

    /**
     * @param null $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException(Module::t('actions', 'Property "elementClass" must be defined'));
        }
        $elementClass = $this->elementClass;
        if ($id !== null) {
            $element = $elementClass::findOne(['id' => $id]);
            if ($element === null) {
                throw new NotFoundHttpException();
            }
        } else {
            $domain = Yii::$app->request->getQueryParam('domain', null);
            $name = Yii::$app->request->getQueryParam('name', null);
            if ($domain === null || $name === null) {
                throw new NotFoundHttpException();
            }
            $element = $elementClass::findOne(['domain' => $domain, 'name' => $name]);
            if ($element === null) {
                throw new NotFoundHttpException();
            }
        }
        return $this->controller->renderPartial($this->view, ['element' => $element]);
    }
}
