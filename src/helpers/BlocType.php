<?php
/**
 * BlocType.php
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

use blackcube\core\models\BlocType as BlocTypeModel;
use blackcube\core\models\TypeBlocType as TypeBlocTypeModel;
use Yii;

/**
 * Class BlocType
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

class BlocType {
    /**
     * @param integer|null $id TypeId
     * @return TypeBlocTypeModel[]
     * @throws \yii\base\InvalidConfigException
     */
    public static function getTypeBlocTypes($id = null)
    {
        $blocTypesQuery = BlocTypeModel::find()->orderBy(['name' => SORT_ASC]);
        $typeBlocTypes = [];
        foreach($blocTypesQuery->each() as $blocType) {
            /* @var $blocType \blackcube\core\models\BlocType */
            $typeBlocType = null;
            if ($id !== null) {
                $typeBlocType = TypeBlocTypeModel::find()->where(['typeId' => $id, 'blocTypeId' => $blocType->id])->one();
            }
            if ($typeBlocType === null) {
                $typeBlocType = Yii::createObject(TypeBlocTypeModel::class);
                if ($id === null) {
                    $typeBlocType->setScenario(TypeBlocTypeModel::SCENARIO_PRE_VALIDATE_BLOCTYPE);
                }
                $typeBlocType->typeId = $id;
                $typeBlocType->blocTypeId = $blocType->id;
                $typeBlocType->allowed = false;
            }
            $typeBlocTypes[] = $typeBlocType;
        }
        return $typeBlocTypes;
    }

}
