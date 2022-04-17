<?php
/**
 * Element.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use blackcube\core\models\Bloc;
use yii\base\ErrorException;
use yii\base\Model;
use Yii;

/**
 * Class Element
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
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
                $transaction = Module::getInstance()->db->beginTransaction();
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
                    throw new ErrorException();
                }
            }
        }
        return $saveStatus;
        // return [$element, $slugForm, $blocs];
    }

}
