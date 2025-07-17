<?php
/**
 * AuthenticationController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\authentication\LoginAction;
use blackcube\admin\actions\authentication\LogoutAction;
use yii\web\Controller;

/**
 * Class AuthenticationController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
