<?php
/**
 * TechnicalController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;
use Yii;

/**
 * Class TechnicalController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 * @since XXX
 */
class TechnicalController extends Controller
{
    public $layout = 'main-login';

    public function actions()
    {
        $actions = parent::actions();
        $actions['error'] = [
            'class' => ErrorAction::class,
            'layout' => 'main',
        ];
        return $actions;
    }

    /**
     * @return string|yii\web\Response
     * @since XXX
     */
    public function actionMaintenance()
    {
        return $this->render('maintenance', []);
    }
}
