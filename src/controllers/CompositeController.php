<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Language;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class CompositeController extends BaseElementController
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'modal', 'blocs', 'index', 'toggle', 'create', 'edit', 'delete', 'preview', 'upload', 'delete',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'blocs', 'toggle'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Composite::class
        ];
        return $actions;
    }

    /**
     * @param string|null $id
     * @return string
     */
    public function actionIndex()
    {
        $compositesQuery = Composite::find()
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        return $this->render('index', [
            'compositesQuery' => $compositesQuery
        ]);
    }

    public function actionToggle($id = null)
    {
        if ($id !== null) {
            $currentComposite = Composite::findOne(['id' => $id]);
            if ($currentComposite !== null) {
                $currentComposite->active = !$currentComposite->active;
                $currentComposite->save(false, ['active']);
            }
        }
        $compositesQuery = Composite::find()
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        return $this->renderPartial('_list', [
            'compositesQuery' => $compositesQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $composite = Yii::createObject(Composite::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $composite
        ]);
        $blocs = $composite->getBlocs()->all();
        $nodeComposite = Yii::createObject(NodeComposite::class);
        $result = $this->saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            $nodeComposite->compositeId = $composite->id;
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            $this->handleTags($composite, $selectedTags);
            $this->handleNodes($composite, $nodeComposite);
            return $this->redirect(['edit', 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $selectTagsData =  $this->prepareTags();
        $nodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);

        return $this->render('form', [
            'composite' => $composite,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'nodesQuery' => $nodesQuery,
            'nodeComposite' => $nodeComposite,
            'selectTagsData' => $selectTagsData,
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
        $composite = Composite::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $composite
        ]);
        $blocs = $composite->getBlocs()->all();
        $nodeComposite = NodeComposite::find()
            ->andWhere(['compositeId' => $composite->id])
            ->orderBy(['order' => SORT_ASC])
            ->one();
        if ($nodeComposite === null) {
            $nodeComposite = Yii::createObject(NodeComposite::class);
            $nodeComposite->compositeId = $composite->id;
        }

        $result = $this->saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            $this->handleTags($composite, $selectedTags);
            $this->handleNodes($composite, $nodeComposite);
            return $this->redirect(['edit', 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $selectTagsData =  $this->prepareTags();
        $nodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);

        return $this->render('form', [
            'composite' => $composite,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'nodesQuery' => $nodesQuery,
            'nodeComposite' => $nodeComposite,
            'selectTagsData' => $selectTagsData,
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
        $composite = Composite::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $composite->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $composite->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $composite->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->redirect(['index']);
    }

    protected function handleNodes($composite, $nodeComposite)
    {
        $status = true;
        if (Yii::$app->request->isPost) {
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $currentAttachedNode = $nodeComposite->node;
                $nodeComposite->load(Yii::$app->request->bodyParams);
                $newAttachedNode = $nodeComposite->node;
                if (($currentAttachedNode !== null) && ($newAttachedNode === null)) {
                    $currentAttachedNode->detachComposite($composite);
                } elseif (($currentAttachedNode !== null) && ($newAttachedNode !== null)) {
                    if ($currentAttachedNode->id !== $newAttachedNode->id) {
                        $currentAttachedNode->detachComposite($composite);
                        $newAttachedNode->attachComposite($composite);
                    }
                } elseif (($currentAttachedNode === null) && ($newAttachedNode !== null)) {
                    $newAttachedNode->attachComposite($composite);
                }
                $nodeComposite = NodeComposite::find()
                    ->andWhere(['compositeId' => $composite->id])
                    ->orderBy(['order' => SORT_ASC])
                    ->one();
                if ($nodeComposite === null) {
                    $nodeComposite = Yii::createObject(NodeComposite::class);
                    $nodeComposite->compositeId = $composite->id;
                }
                $transaction->commit();
            } catch(\Exception $e) {
                $status = false;
                $transaction->rollBack();
            }
        }
        return $status;
    }

}
