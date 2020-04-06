<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Tag;
use blackcube\core\web\actions\ResumableUploadAction;
use blackcube\core\web\actions\ResumablePreviewAction;
use blackcube\core\web\actions\ResumableDeleteAction;
use yii\base\ErrorException;
use yii\base\Model;
use yii\web\Controller;
use Yii;

abstract class BaseElementController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['upload'] = [
            'class' => ResumableUploadAction::class,
        ];
        $actions['preview'] = [
            'class' => ResumablePreviewAction::class,
        ];
        $actions['delete'] = [
            'class' => ResumableDeleteAction::class,
        ];
        return $actions;
    }


    /**
     * @param ElementInterface $element
     * @param Bloc[] $blocs
     * @param SlugForm $slugForm
     * @return bool
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    protected function saveElement(ElementInterface &$element, &$blocs, SlugForm &$slugForm)
    {
        $saveStatus = false;
        if (Yii::$app->request->isPost) {
            Model::loadMultiple($blocs, Yii::$app->request->bodyParams);
            $element->load(Yii::$app->request->bodyParams);
            $slugForm->multiLoad(Yii::$app->request->bodyParams);

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

    /**
     * (De)tach tags to element
     * @param TaggableInterface $element
     * @param array $selectedTags
     */
    protected function handleTags(TaggableInterface $element, $selectedTags = [])
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

}
