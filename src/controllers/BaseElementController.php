<?php
/**
 * BaseElementController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
