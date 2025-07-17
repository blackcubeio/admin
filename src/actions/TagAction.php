<?php
/**
 * TagAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions;

use blackcube\admin\models\TagForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class TagAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class TagAction extends BaseElementAction
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_tag';

    /**
     * @param null $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException(Module::t('actions', 'Property "elementClass" must be defined'));
        }
        $elementClass = $this->elementClass;
        if ($id !== null) {
            $element = $elementClass::find()
                ->andWhere(['id' => $id])
                ->with('tags')
                ->one();
            if ($element === null) {
                throw new NotFoundHttpException();
            }
        } else {
            throw new NotFoundHttpException();
        }
        $selectedTags = ArrayHelper::getColumn($element->tags, 'id');
        $categoriesQuery = Category::find()
            ->with('tags')
            ->orderBy(['name' => SORT_ASC]);
        /**
         * @var $element ElementInterface
         */
        $formElements = [];

        foreach ($categoriesQuery->each() as $category) {
            $form = ['category' => $category];
            $tags = [];
            foreach($category->getTags()->orderBy(['name' => SORT_ASC])->each() as $tag) {
                $tags[] = Yii::createObject([
                    'class' => TagForm::class,
                    'id' => $tag->id,
                    'checked' => in_array($tag->id, $selectedTags),
                    'name' => $tag->name,
                ]);
            }
            $form['tags'] = $tags;
            $formElements[] = $form;
        }

        $saved = null;
        if (Yii::$app->request->isPost) {
            $saved = true;
            $tags = [];
            foreach ($formElements as $formElement) {
                foreach ($formElement['tags'] as $tag) {
                    $tags[] = $tag;
                }
            }
            Model::loadMultiple($tags, Yii::$app->request->bodyParams);
            $selectedTags = ArrayHelper::getColumn(array_filter($tags, function($item) { return $item->checked; }), 'id');
            $existingTags = [];
            foreach ($element->tags as $currentTag) {
                if (in_array($currentTag->id, $selectedTags) === false) {
                    $saved = $saved && $element->detachTag($currentTag);
                } else {
                    $existingTags[] = $currentTag->id;
                }
            }
            $missingTags = array_diff($selectedTags, $existingTags);
            foreach($missingTags as $missingTagId) {
                $missingTag = Tag::findOne(['id' => $missingTagId]);
                if ($missingTag !== null) {
                    $saved = $saved && $element->attachTag($missingTag);
                }
            }
            $formElements = [];
            if ($saved) {
                $element->refresh();
            }
            $selectedTags = ArrayHelper::getColumn($element->tags, 'id');
            foreach ($categoriesQuery->each() as $category) {
                $form = ['category' => $category];
                $tags = [];
                foreach($category->getTags()->orderBy(['name' => SORT_ASC])->each() as $tag) {
                    $tags[] = Yii::createObject([
                        'class' => TagForm::class,
                        'id' => $tag->id,
                        'checked' => in_array($tag->id, $selectedTags),
                        'name' => $tag->name,
                    ]);
                }
                $form['tags'] = $tags;
                $formElements[] = $form;
            }

        }

        return $this->controller->renderPartial($this->view, [
            'element' => $element,
            'formElements' => $formElements,
            'selectedTags' => $selectedTags,
            'saved' => $saved,
        ]);
    }
    
}
