<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\models\TagManager;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Language;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use blackcube\core\web\actions\ResumableUploadAction;
use blackcube\core\web\actions\ResumablePreviewAction;
use blackcube\core\web\actions\ResumableDeleteAction;
use yii\base\ErrorException;
use yii\base\Event;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class NodeController extends BaseElementController
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Node::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Node::class
        ];
        return $actions;
    }

    /**
     * @param string|null $id
     * @return string
     */
    public function actionIndex()
    {
        $nodesQuery = Node::find()
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['left' => SORT_ASC]);
        return $this->render('index', [
            'nodesQuery' => $nodesQuery
        ]);
    }

    public function actionToggle($id = null)
    {
        if (Yii::$app->request->isAjax) {
            if ($id !== null) {
                $currentNode = Node::findOne(['id' => $id]);
                if ($currentNode !== null) {
                    $currentNode->active = !$currentNode->active;
                    $currentNode->save(false, ['active']);
                }
            }
            $nodesQuery = Node::find()
                ->with('slug.seo')
                ->with('slug.sitemap')
                ->orderBy(['name' => SORT_ASC]);
            return $this->renderPartial('_list', [
                'nodesQuery' => $nodesQuery
            ]);
        }
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $node = Yii::createObject(Node::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $node
        ]);
        $blocs = $node->getBlocs()->all();
        $result = $this->saveElement($node, $blocs, $slugForm);
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            $this->handleTags($node, $selectedTags);
            return $this->redirect(['edit', 'id' => $node->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $targetNodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $selectTagsData =  Tag::find()
            ->innerJoinWith('category', true)
            ->orderBy([
                Category::tableName().'.name' => SORT_ASC,
                Tag::tableName().'.name' => SORT_ASC
            ])->select([
                Tag::tableName().'.id as tagId',
                Tag::tableName().'.name as tagName',
                Tag::tableName().'.categoryId',
                Category::tableName().'.name as categoryName'
            ])->asArray()->all();

        return $this->render('form', [
            'node' => $node,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'selectTagsData' => $selectTagsData,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id)
    {
        $node = Node::findOne(['id' => $id]);
        if ($node === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $node
        ]);

        $parentNode = $node->getParent()->one();
        $blocs = $node->getBlocs()->all();
        if (Yii::$app->request->isPost) {
            $moveNode =  Yii::$app->request->getBodyParam('moveNode', false);
            if ($moveNode == true) {
                $newTargetNodeId = Yii::$app->request->getBodyParam('moveNodeTarget', null);
                $moveNodeTarget = Node::findOne(['id' => $newTargetNodeId]);
                $moveNodeMode =  Yii::$app->request->getBodyParam('moveNodeMode', 'into');
                if ($moveNodeTarget === null) {
                    $moveNode = false;
                }
            }
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
        }
        try {
            if (isset($moveNode) && $moveNode == true && isset($moveNodeTarget, $moveNodeMode)) {
                switch ($moveNodeMode) {
                    case 'into':
                        $node->moveInto($moveNodeTarget);
                        break;
                    case 'before':
                        $node->moveBefore($moveNodeTarget);
                        break;
                    case 'after':
                        $node->moveAfter($moveNodeTarget);
                        break;
                }
            }
            $result = $this->saveElement($node, $blocs, $slugForm);
            if (Yii::$app->request->isPost) {
                $transaction->commit();
            }
        } catch(\Exception $e) {
            $result = false;
            if (Yii::$app->request->isPost) {
                $transaction->rollBack();
            }
        }
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            $this->handleTags($node, $selectedTags);
            return $this->redirect(['edit', 'id' => $node->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $targetNodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $selectTagsData =  Tag::find()
            ->innerJoinWith('category', true)
            ->orderBy([
                Category::tableName().'.name' => SORT_ASC,
                Tag::tableName().'.name' => SORT_ASC
            ])->select([
                Tag::tableName().'.id as tagId',
                Tag::tableName().'.name as tagName',
                Tag::tableName().'.categoryId',
                Category::tableName().'.name as categoryName'
            ])->asArray()->all();

        return $this->render('form', [
            'node' => $node,
            'parentNode' => $parentNode,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'selectTagsData' => $selectTagsData,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $node = Node::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $node->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $node->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $node->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->redirect(['index']);
    }

}
