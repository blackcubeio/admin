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
     * (De)tach tags to element
     * @param TaggableInterface $element
     * @param array $selectedTags
     */
    public static function handleTags(TaggableInterface $element, $selectedTags = [])
    {
        $currentTags = $element->getTags()->all();
        $existingTags = [];
        foreach ($currentTags as $currentTag) {
            if (in_array($currentTag->id, $selectedTags) === false) {
                $element->detachTag($currentTag);
            } else {
                $existingTags[] = $currentTag->id;
            }
        }
        $missingTags = array_diff($selectedTags, $existingTags);
        foreach($missingTags as $missingTagId) {
            $missingTag = Tag::findOne(['id' => $missingTagId]);
            if ($missingTag !== null) {
                $element->attachTag($missingTag);
            }
        }
    }

    /**
     * @return array list of tags
     */
    public static function prepareTags()
    {
        return Tag::find()
            ->innerJoinWith('category', true)
            ->orderBy([
                Category::tableName().'.[[name]]' => SORT_ASC,
                Tag::tableName().'.[[name]]' => SORT_ASC
            ])->select([
                Tag::tableName().'.[[id]] as [[tagId]]',
                Tag::tableName().'.[[name]] as [[tagName]]',
                Tag::tableName().'.[[categoryId]]',
                Category::tableName().'.[[name]] as [[categoryName]]'
            ])->asArray()->all();
    }

    /**
     * @param ElementInterface $element
     * @param Bloc[] $blocs
     * @param SlugForm $slugForm
     * @return bool
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public static function saveElement(ElementInterface &$element, &$blocs, SlugForm &$slugForm)
    {
        $saveStatus = false;
        if (Yii::$app->request->isPost) {
            Model::loadMultiple($blocs, Yii::$app->request->bodyParams);
            $element->load(Yii::$app->request->bodyParams);
            $slugForm->multiLoad(Yii::$app->request->bodyParams);
            if ($slugForm->getSlug() !== null) {
                $slugForm->getSlug()->active = $element->active;
            }
            if ($element->validate() && $slugForm->preValidate() && Model::validateMultiple($blocs)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                $slugFormStatus = $slugForm->save();
                $elementStatus = $element->save();
                $blocStatus = true;
                foreach($blocs as $bloc) {
                    $bloc->active = true;
                    $blocStatus = $blocStatus && $bloc->save();
                }
                if ($slugFormStatus && $elementStatus && $blocStatus) {
                    if ($slugForm->hasSlug) {
                        $element->attachSlug($slugForm->getSlug());
                    } else {
                        $element->detachSlug();
                    }
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
