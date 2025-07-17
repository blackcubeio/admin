<?php
/**
 * Type.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use blackcube\core\models\Type as TypeModel;
use blackcube\core\models\TypeBlocType;
use Yii;

/**
 * Class Type
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

class Type {
    /**
     * @param string|null $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function getTypeBlocTypes($id = null)
    {
        $typeQuery = TypeModel::find()->orderBy(['name' => SORT_ASC]);
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
