<?php
/**
 * Element.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use yii\base\ErrorException;
use yii\base\Model;
use Yii;

/**
 * Class Element
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

class Element {

    /**
     * @param ElementInterface $element
     * @param Bloc[] $blocs
     * @return bool
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public static function saveElement(ElementInterface &$element, &$blocs)
    {
        $saveStatus = false;
        if (Yii::$app->request->isPost) {
            Model::loadMultiple($blocs, Yii::$app->request->bodyParams);
            $element->load(Yii::$app->request->bodyParams);
            if ($element->validate() && Model::validateMultiple($blocs)) {
                $transaction = Module::getInstance()->get('db')->beginTransaction();
                $elementStatus = $element->save();
                $blocStatus = true;
                foreach($blocs as $bloc) {
                    $bloc->active = true;
                    $blocStatus = $blocStatus && $bloc->save();
                }
                if ($elementStatus && $blocStatus) {
                    $transaction->commit();
                    $saveStatus = true;
                } else {
                    $transaction->rollBack();
                    $saveStatus = false;
                }
            }
        }
        return $saveStatus;
    }

}
