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
 * @package blackcube\admin\actions\user
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\models\Administrator;
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
 * @package blackcube\admin\actions\user
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
            $currentUser = Administrator::findOne(['id' => $id]);
            if ($currentUser !== null) {
                $currentUser->active = !$currentUser->active;
                $currentUser->save(false, ['active', 'dateUpdate']);
            }
        }
        return $this->controller->renderPartial($this->view, [
            'user' => $currentUser
        ]);
    }
}
