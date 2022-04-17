<?php
/**
 * BaseElementController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\core\web\actions\ResumableUploadAction;
use blackcube\core\web\actions\ResumablePreviewAction;
use blackcube\core\web\actions\ResumableDeleteAction;
use yii\web\Controller;
use Yii;

/**
 * Class BaseElementController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
abstract class BaseElementController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['file-upload'] = [
            'class' => ResumableUploadAction::class,
        ];
        $actions['file-preview'] = [
            'class' => ResumablePreviewAction::class,
        ];
        $actions['file-delete'] = [
            'class' => ResumableDeleteAction::class,
        ];
        return $actions;
    }


}
