<?php
/**
 * NodeController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Language;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class NodeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class NodeController extends BaseElementController
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
                        'modal', 'index',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'blocs', 'composites', 'search',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs', 'composites', 'search',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_DELETE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'file-preview', 'file-upload', 'file-delete',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'blocs', 'toggle', 'composites', 'search'],
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
            'elementClass' => Node::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Node::class
        ];
        return $actions;
    }

    /**
     * @return string|Response
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

    /**
     * @param null $id
     * @return string|Response
     */
    public function actionToggle($id = null)
    {
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

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
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
        $compositesQuery = $node->getComposites();
        $result = $this->saveElement($node, $blocs, $slugForm);
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            $this->handleTags($node, $selectedTags);
            return $this->redirect(['edit', 'id' => $node->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $targetNodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $selectTagsData =  $this->prepareTags();

        return $this->render('form', [
            'node' => $node,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'selectTagsData' => $selectTagsData,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'compositesQueyr' => $compositesQuery,
            'languagesQuery' => $languagesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
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
        $compositesQuery = $node->getComposites();
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
        $selectTagsData =  $this->prepareTags();

        return $this->render('form', [
            'node' => $node,
            'parentNode' => $parentNode,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'selectTagsData' => $selectTagsData,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'compositesQuery' => $compositesQuery,
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
        if ($node === null) {
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

    public function actionComposites($id)
    {
        if (Yii::$app->request->isPost) {
            $node = Node::findOne(['id' => $id]);
            if ($node === null) {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['compositeAdd'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeAdd']])->one();
                if ($composite !== null) {
                    $node->attachComposite($composite, -1);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDelete'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeDelete']])->one();
                if ($composite !== null) {
                    $node->detachComposite($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeUp'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeUp']])->one();
                if ($composite !== null) {
                    $node->moveCompositeUp($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDown'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeDown']])->one();
                if ($composite !== null) {
                    $node->moveCompositeDown($composite);
                }
            }
            $compositesQuery = $node->getComposites();
            return $this->renderPartial('_composites', ['compositesQuery' => $compositesQuery, 'element' => $node]);
        }
    }

    /**
     * @param string $query
     * @return array
     */
    public function actionSearch($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $compositeQuery = Composite::findOrphans()
            ->orderBy(['name' => SORT_ASC])
            ->andWhere(['like', 'name', $query]);
        return $compositeQuery
            ->select(['id', 'name'])
            ->all();
    }



}
