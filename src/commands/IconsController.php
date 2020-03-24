<?php

namespace blackcube\admin\commands;

use blackcube\admin\models\Administrator;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

class IconsController extends Controller
{

    public function actionParse()
    {
        $this->stdout(Yii::t('blackcube.admin', 'Generate Icons'."\n"));
        $files = scandir('/Users/pgaultier/Downloads/zondicons');
        foreach($files as $file) {
            if (preg_match('/([^.]+)\.svg/', $file, $matches) > 0) {
                $this->stdout($matches[1]."\n");
                $data = file_get_contents('/Users/pgaultier/Downloads/zondicons/'.$file);
                var_dump($data);
                $domData = new \DOMDocument();
                $domData->loadXML($data);
                foreach($domData->childNodes as $childNode) {
                    echo $childNode->getAtt;
                }
            }
        }
        return ExitCode::OK;
    }
}
