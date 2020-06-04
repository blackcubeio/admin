<?php
/**
 * Type.php
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

use blackcube\admin\Module;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\TypeBlocType;
use Yii;

/**
 * Class Type
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

class Type {
    /**
     * @param string|null $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function getTypeBlocTypes($id = null)
    {
        $typeQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $typeBlocTypes = [];
        foreach($typeQuery->each() as $type) {
            /* @var $type \blackcube\core\models\Type */
            $typeBlocType = null;
            if ($id !== null) {
                $typeBlocType = TypeBlocType::find()->where(['typeId' => $type->id, 'blocTypeId' => $id])->one();
            }
            if ($typeBlocType === null) {
                $typeBlocType = Yii::createObject(TypeBlocType::class);
                $typeBlocType->typeId = $type->id;
                $typeBlocType->blocTypeId = $id;
                $typeBlocType->allowed = false;
            }
            $typeBlocTypes[] = $typeBlocType;
        }
        return $typeBlocTypes;
    }

}
