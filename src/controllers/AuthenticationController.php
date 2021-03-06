<?php
/**
 * AuthenticationController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\authentication\LoginAction;
use blackcube\admin\actions\authentication\LogoutAction;
use yii\web\Controller;
use Yii;

/**
 * Class AuthenticationController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class AuthenticationController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public $layout = 'main-login';

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['login'] = [
            'class' => LoginAction::class,
        ];
        $actions['logout'] = [
            'class' => LogoutAction::class,
        ];
        return $actions;
    }
}
