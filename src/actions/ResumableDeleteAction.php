<?php
/**
 * ResumableDeleteAction.php
 *
 * PHP version 5.6+
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2017 Ibitux
 * @license http://www.ibitux.com/license license
 * @version 1.3.1
 * @link http://www.ibitux.com
 * @package application\actions
 */

namespace blackcube\admin\actions;

use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\ViewAction;
use Yii;
use function GuzzleHttp\Psr7\str;

/**
 * delete only tmp files action
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2017 Ibitux
 * @license http://www.ibitux.com/license license
 * @version 1.3.1
 * @link http://www.ibitux.com
 * @package application\actions
 * @since 1.3.0
 */
class ResumableDeleteAction extends ViewAction
{
    public $uploadAlias = '@app/runtime/blackcube/uploads/';
    /**
     * @inheritdoc
     */
    public function run()
    {
        $name = Yii::$app->request->getQueryParam('name', null);
        // var_dump($name); die();
        if (strncmp('@blackcubetmp/', $name, 14) === 0) {
            $realNameAlias = str_replace('@blackcubetmp/', $this->uploadAlias, $name);
            $realName = Yii::getAlias($realNameAlias);
            if (file_exists($realName) === false) {
                throw new NotFoundHttpException();
            }
            unlink($realName);
            throw new HttpException(204);
        }
        throw new NotFoundHttpException();
    }

}
