<?php
/**
 * TechnicalController.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;
use Yii;

/**
 * Class TechnicalController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
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
