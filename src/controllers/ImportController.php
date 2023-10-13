<?php
/**
 * ImportController.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\ImportForm;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use blackcube\core\Module;
use blackcube\core\Module as CoreModule;
use blackcube\core\web\actions\ResumableDeleteAction;
use blackcube\core\web\actions\ResumablePreviewAction;
use blackcube\core\web\actions\ResumableUploadAction;
use yii\db\ActiveQuery;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;

/**
 * Class ImportController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class ImportController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['file-upload'] = [
            'class' => ResumableUploadAction::class,
        ];
        $actions['file-preview'] = [
            'class' => ResumablePreviewAction::class,
        ];
        $actions['file-delete'] = [
            'class' => ResumableDeleteAction::class,
        ];
        return $actions;
    }
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
                        'index','import'
                    ],
                    'roles' => [
                        Rbac::PERMISSION_COMPOSITE_IMPORT,
                        Rbac::PERMISSION_NODE_IMPORT,
                        Rbac::PERMISSION_CATEGORY_IMPORT,
                        Rbac::PERMISSION_TAG_IMPORT
                    ],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'import-composite'
                    ],
                    'roles' => [
                        Rbac::PERMISSION_COMPOSITE_IMPORT
                    ]
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'import-node'
                    ],
                    'roles' => [
                        Rbac::PERMISSION_NODE_IMPORT
                    ]
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'import-category'
                    ],
                    'roles' => [
                        Rbac::PERMISSION_CATEGORY_IMPORT
                    ]
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'import-tag'
                    ],
                    'roles' => [
                        Rbac::PERMISSION_TAG_IMPORT
                    ]
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'file-preview', 'file-upload', 'file-delete',
                    ],
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @var callable
     */
    public $typesQuery;

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getTypesQuery()
    {
        $typesQuery = null;
        if (is_callable($this->typesQuery) === true) {
            $typesQuery = call_user_func($this->typesQuery);
        }
        if ($typesQuery === null || (($typesQuery instanceof ActiveQuery) === false)) {
            $typesQuery = Type::find();
        }
        return $typesQuery;
    }

    public $nodesQuery;
    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getNodesQuery()
    {
        $nodesQuery = null;
        if (is_callable($this->nodesQuery) === true) {
            $nodesQuery = call_user_func($this->nodesQuery);
        }
        if ($nodesQuery === null || (($nodesQuery instanceof ActiveQuery) === false)) {
            $nodesQuery = Node::find();
        }
        return $nodesQuery;
    }

    public $tagsQuery;
    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getTagsQuery()
    {
        $tagsQuery = null;
        if (is_callable($this->tagsQuery) === true) {
            $tagsQuery = call_user_func($this->tagsQuery);
        }
        if ($tagsQuery === null || (($tagsQuery instanceof ActiveQuery) === false)) {
            $tagsQuery = Tag::find();
        }
        return $tagsQuery;
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        Yii::$app->session->remove('importFile');
        $importForm = new ImportForm();

        if (Yii::$app->request->isPost) {
            $importForm->load(Yii::$app->request->post());
            if ($importForm->validate()) {
                $uploadAlias = CoreModule::getInstance()->uploadAlias;
                $uploadTmp = trim(CoreModule::getInstance()->uploadTmpPrefix, '/').'/';
                if (strncmp($uploadTmp, $importForm->importFile, strlen($uploadTmp)) === 0) {
                    Yii::$app->session->set('importFile', $importForm->importFile);
                    return $this->redirect(['import']);
                }

            }

        }
        return $this->render('form', [
            'importForm' => $importForm
        ]);
    }
    public function actionImport() {

        $file = Yii::$app->session->get('importFile');

        if ($file === null) {
            return $this->redirect(['index']);
        }
        $uploadAlias = CoreModule::getInstance()->uploadAlias;
        $uploadTmp = trim(CoreModule::getInstance()->uploadTmpPrefix, '/').'/';
        if (strncmp($uploadTmp, $file, strlen($uploadTmp)) === 0) {
            $finalFilename = pathinfo($file, PATHINFO_BASENAME);
            // file ok
            $realFilename = Yii::getAlias($uploadAlias.'/'.$finalFilename);
            if (file_exists($realFilename) === false) {
                return $this->redirect(['index']);
            }
            $data = file_get_contents($realFilename);
            try {
                $jsonData = Json::decode($data);
                if (isset($jsonData['elementType']) === false) {
                    throw new UnprocessableEntityHttpException('Missing elementType');
                }
                switch ($jsonData['elementType']) {
                    case Composite::getElementType():
                        $this->redirect(['import-composite']);
                        break;
                    case Node::getElementType():
                        $this->redirect(['import-node']);
                        break;
                    case Tag::getElementType():
                        $this->redirect(['import-tag']);
                        break;
                    case Category::getElementType():
                        $this->redirect(['import-category']);
                        break;
                    default:
                        throw new UnprocessableEntityHttpException('Missing elementType');
                    break;

                }
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                throw $e;
            }
        }
    }

    public function actionImportComposite()
    {
        $jsonData = $this->getJsonData(Composite::getElementType());
        $jsonData['active'] = false;
        if (Yii::$app->request->isPost) {
            if ($this->importComposite($jsonData) === true) {
                return $this->redirect(['index']);
            } else {
                throw new UnprocessableEntityHttpException('Unable to import composite');
            }
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $nodesQuery = $this->getNodesQuery()
            ->orderBy(['left' => SORT_ASC]);
        $tagsQuery = $this->getTagsQuery()
            ->orderBy(['name' => SORT_ASC]);

        $frequencies = array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
        $priorities = array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
        return $this->render(
            'composite',
            [
                'jsonData' => $jsonData,
                'typesQuery' => $typesQuery,
                'nodesQuery' => $nodesQuery,
                'tagsQuery' => $tagsQuery,
                'languagesQuery' => $languagesQuery,
                'frequencies' => $frequencies,
                'priorities' => $priorities,
            ]
        );
    }
    public function actionImportNode()
    {
        $jsonData = $this->getJsonData(Node::getElementType());
        $jsonData['active'] = false;
        if (Yii::$app->request->isPost) {
            if ($this->importNode($jsonData) === true) {
                return $this->redirect(['index']);
            } else {
                throw new UnprocessableEntityHttpException('Unable to import node');
            }
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $tagsQuery = $this->getTagsQuery()
            ->orderBy(['name' => SORT_ASC]);

        $frequencies = array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
        $priorities = array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
        return $this->render(
            'node',
            [
                'jsonData' => $jsonData,
                'typesQuery' => $typesQuery,
                'tagsQuery' => $tagsQuery,
                'languagesQuery' => $languagesQuery,
                'frequencies' => $frequencies,
                'priorities' => $priorities,
            ]
        );
    }
    public function actionImportTag()
    {
        $jsonData = $this->getJsonData(Tag::getElementType());
        $jsonData['active'] = false;
        if (Yii::$app->request->isPost) {
            if ($this->importTag($jsonData) === true) {
                return $this->redirect(['index']);
            } else {
                throw new UnprocessableEntityHttpException('Unable to import tag');
            }
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $nodesQuery = $this->getNodesQuery()
            ->orderBy(['left' => SORT_ASC]);
        $compositesQuery = Composite::find()
            ->orderBy(['name' => SORT_ASC]);
        $tagsQuery = $this->getTagsQuery()
            ->orderBy(['name' => SORT_ASC]);
        $categoriesQuery = Category::find()
            ->orderBy(['name' => SORT_ASC]);

        $frequencies = array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
        $priorities = array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
        return $this->render(
            'tag',
            [
                'jsonData' => $jsonData,
                'typesQuery' => $typesQuery,
                'tagsQuery' => $tagsQuery,
                'nodesQuery' => $nodesQuery,
                'compositesQuery' => $compositesQuery,
                'categoriesQuery' => $categoriesQuery,
                'languagesQuery' => $languagesQuery,
                'frequencies' => $frequencies,
                'priorities' => $priorities,
            ]
        );
    }
    public function actionImportCategory()
    {
        $jsonData = $this->getJsonData(Category::getElementType());
        $jsonData['active'] = false;
        if (Yii::$app->request->isPost) {
            if ($this->importCategory($jsonData) === true) {
                return $this->redirect(['index']);
            } else {
                throw new UnprocessableEntityHttpException('Unable to import category');
            }
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $nodesQuery = $this->getNodesQuery()
            ->orderBy(['left' => SORT_ASC]);
        $compositesQuery = Composite::find()
            ->orderBy(['name' => SORT_ASC]);
        $tagsQuery = $this->getTagsQuery()
            ->orderBy(['name' => SORT_ASC]);
        $categoriesQuery = Category::find()
            ->orderBy(['name' => SORT_ASC]);

        $frequencies = array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
        $priorities = array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
        return $this->render(
            'category',
            [                'jsonData' => $jsonData,
                'typesQuery' => $typesQuery,
                'tagsQuery' => $tagsQuery,
                'nodesQuery' => $nodesQuery,
                'compositesQuery' => $compositesQuery,
                'categoriesQuery' => $categoriesQuery,
                'languagesQuery' => $languagesQuery,
                'frequencies' => $frequencies,
                'priorities' => $priorities,
            ]
        );
    }
    private function getJsonData($elementType) {
        $file = Yii::$app->session->get('importFile');

        if ($file === null) {
            return $this->redirect(['index']);
        }
        $uploadAlias = CoreModule::getInstance()->uploadAlias;
        $uploadTmp = trim(CoreModule::getInstance()->uploadTmpPrefix, '/').'/';
        if (strncmp($uploadTmp, $file, strlen($uploadTmp)) === 0) {
            $finalFilename = pathinfo($file, PATHINFO_BASENAME);
            // file ok
            $realFilename = Yii::getAlias($uploadAlias.'/'.$finalFilename);
            if (file_exists($realFilename) === false) {
                return $this->redirect(['index']);
            }
            $data = file_get_contents($realFilename);
            try {
                $jsonData = Json::decode($data);
                if (isset($jsonData['elementType']) === false) {
                    throw new UnprocessableEntityHttpException('Missing elementType');
                }
                if ($jsonData['elementType'] !== $elementType) {
                    throw new UnprocessableEntityHttpException('Element type mismatch');
                }
            } catch (\Exception $e) {
                Yii::error($e->getMessage());
                throw $e;
            }
            unset($jsonData['elementType']);
            return $jsonData;
        }
    }

    private function importComposite($data) {
        $transaction = Module::getInstance()->db->beginTransaction();
        try {

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    private function importNode($data) {
        $transaction = Module::getInstance()->db->beginTransaction();
        try {

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    private function importTag($data) {
        $transaction = Module::getInstance()->db->beginTransaction();
        try {

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
    private function importCategory($data) {
        $transaction = Module::getInstance()->db->beginTransaction();
        try {

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return true;
    }
}
