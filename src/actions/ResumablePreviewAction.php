<?php
/**
 * ResumablePreviewAction.php
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

use Imagine\Image\ManipulatorInterface;
use yii\base\Event;
use yii\imagine\Image;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\ViewAction;
use Yii;
use function GuzzleHttp\Psr7\str;

/**
 * preview action
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2017 Ibitux
 * @license http://www.ibitux.com/license license
 * @version 1.3.1
 * @link http://www.ibitux.com
 * @package application\actions
 * @since 1.3.0
 */
class ResumablePreviewAction extends ViewAction
{
    public $uploadAlias = '@app/runtime/blackcube/uploads/';
    public $filetypeIconAlias = '@blackcube/admin/assets/static/files/';
    /**
     * @inheritdoc
     */
    public function run()
    {
        $name = Yii::$app->request->getQueryParam('name', null);
        $width = Yii::$app->request->getQueryParam('width', null);
        $height = Yii::$app->request->getQueryParam('height', null);
        // var_dump($name); die();
        if (strncmp('@blackcubetmp/', $name, 14) === 0) {
            $realNameAlias = str_replace('@blackcubetmp/', $this->uploadAlias, $name);
            $realName = Yii::getAlias($realNameAlias);
            if (file_exists($realName) === false) {
                throw new NotFoundHttpException();
            }
            $mimeType = mime_content_type($realName);
            $fileName = pathinfo($realName, PATHINFO_BASENAME);
            if (strncmp('image/', $mimeType, 6) !== 0) {
                $realName = $this->prepareImage($fileName);
                $mimeType = mime_content_type($realName);
            } else {
                Image::$thumbnailBackgroundAlpha = 0;
                $image = Image::thumbnail($realName, 200, 200, ManipulatorInterface::THUMBNAIL_INSET);
                $thumbnailName = Yii::getAlias($this->uploadAlias.'thumb_200x200'.$fileName);
                $image->save($thumbnailName);
                $realName = $thumbnailName;
                // Garbage collector to avoid duplicates
                Event::on(Response::class, Response::EVENT_AFTER_SEND, function() use ($thumbnailName) {
                    if (file_exists($thumbnailName)) {
                        unlink($thumbnailName);
                    }
                });
            }
            $handle = fopen($realName, 'r');

        } elseif (strncmp('@flysystem/', $name, 11) === 0) {
            $realName = str_replace('@flysystem/', '', $name);
            // file is in fly system (creocoder)
            $mimeType = Yii::$app->fs->getMimetype($realName);
            $fileName = pathinfo($realName, PATHINFO_BASENAME);
            if (strncmp('image/', $mimeType, 6) !== 0) {
                $realName = $this->prepareImage($fileName);
                $mimeType = mime_content_type($realName);
                $handle = fopen($realName, 'r');
            } else {
                $handle = Yii::$app->fs->readStream($realName);
            }
        } else {
            $name = str_replace('@web/', '@webroot/', $name);
            $realName = Yii::getAlias($name);
            if (file_exists($realName) === false) {
                throw new NotFoundHttpException();
            }
            $mimeType = mime_content_type($realName);
            $fileName = pathinfo($realName, PATHINFO_BASENAME);
            if (strncmp('image/', $mimeType, 6) !== 0) {
                $realName = $this->prepareImage($fileName);
                $mimeType = mime_content_type($realName);
            }
            $handle = fopen($realName, 'r');
        }
        return Yii::$app->response->sendStreamAsFile($handle, $fileName, ['inline' => true, 'mimeType' => $mimeType]);
    }

    protected function prepareImage($filename) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $iconAlias = $this->filetypeIconAlias . $extension . '.png';
        $iconPath = Yii::getAlias($iconAlias);
        if (file_exists($iconPath) === true) {
            return $iconPath;
        } else {
            $iconAlias = $this->filetypeIconAlias . 'dot.png';
            return Yii::getAlias($iconAlias);
        }
    }
    
}
