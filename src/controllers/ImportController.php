<?php
/**
 * ImportController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\controllers;

use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\models\ImportForm;
use blackcube\admin\Module;
use blackcube\core\components\Flysystem;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
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
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
            $compositeId = $this->importComposite($jsonData);
            if ($compositeId !== false) {
                return $this->redirect(['/'.Module::getInstance()->getUniqueId().'/composite/edit', 'id' => $compositeId]);
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
            $nodeId = $this->importNode($jsonData);
            if ($nodeId !== false) {
                return $this->redirect(['/'.Module::getInstance()->getUniqueId().'/node/edit', 'id' => $nodeId]);
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
            $tagId = $this->importTag($jsonData);
            if ($tagId !== false) {
                return $this->redirect(['/'.Module::getInstance()->getUniqueId().'/tag/edit', 'id' => $tagId]);
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
            $categoryId = $this->importCategory($jsonData);
            if ($categoryId !== false) {
                return $this->redirect(['/'.Module::getInstance()->getUniqueId().'/category/edit', 'id' => $categoryId]);
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
            if (isset($jsonData['slug']['path']) === true) {
                $slugPath = $jsonData['slug']['path'];
                $slug = Slug::find()->andWhere(['path' => $slugPath])->one();
                if ($slug !== null) {
                    $i = 0;
                    do {
                        $i++;
                        $slug = Slug::find()->andWhere(['path' => $slugPath.'-'.str_pad($i, 3, '0', STR_PAD_LEFT)])->one();
                    } while ($slug !== null);
                    $jsonData['slug']['path'] = $slugPath.'-'.str_pad($i, 3, '0', STR_PAD_LEFT);
                    $data = Json::encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    file_put_contents($realFilename, $data);
                }
            }
            unset($jsonData['elementType']);
            return $jsonData;
        }
    }

    private function saveSlug($data)
    {
        if ($data !== null)
        {
            $slug = new Slug();
            $slug->host = $data['host'] ?? null;
            $slug->path = $data['path'];
            $slug->active = $data['active'];
            $slug->dateCreate = $data['dateCreate'];
            $slug->dateUpdate = $data['dateUpdate'];
            if ($slug->save(false)) {
                if (isset($data['seo'])) {
                    $seo = new Seo();
                    $seo->slugId = $slug->id;
                    $seo->active = $data['seo']['active'] ?? false;
                    $seo->title = $data['seo']['title'] ?? null;
                    $seo->description = $data['seo']['description'] ?? null;
                    $seo->nofollow = $data['seo']['nofollow'] ?? false;
                    $seo->noindex = $data['seo']['noindex'] ?? false;
                    if ($data['seo']['canonical'] === true) {
                        $seo->canonicalSlugId = $slug->id;
                    } else if (is_string($data['seo']['canonical']) === true) {
                        $canonicalSlug = Slug::find()->andWhere(['path' => $data['seo']['canonical']])->one();
                        if ($canonicalSlug !== null) {
                            $seo->canonicalSlugId = $canonicalSlug->id;
                        }
                    }
                    $seo->og = $data['seo']['og'] ?? false;
                    $seo->ogType = $data['seo']['ogType'] ?? null;
                    $seo->twitter = $data['seo']['twitter'] ?? false;
                    $seo->twitterCard = $data['seo']['twitterCard'] ?? null;
                    $seo->dateCreate = $data['seo']['dateCreate'];
                    $seo->dateUpdate = $data['seo']['dateUpdate'];
                    $seo->save(false);
                    $imageBase64 = $data['seo']['image'] ?? null;
                    if (empty($imageBase64) === false) {
                        [$type, $encoding, $name, $content] = preg_split('/\s*:\s*/', $imageBase64, -1, PREG_SPLIT_NO_EMPTY);
                        if ($encoding === 'base64') {
                            $data = base64_decode($content);
                            $prefix = trim(CoreModule::getInstance()->uploadFsPrefix, '/') . '/';
                            $fs = CoreModule::getInstance()->get('fs');
                            /* @var $fs Flysystem */
                            $targetFilename = '/seo/'.$seo->id.'/'.trim($name, '/');
                            $fs->write($targetFilename, $data);
                            $seo->image = $prefix.$targetFilename;
                            $seo->save(false);
                            //todo upload image
                        }
                    }
                }
                if (isset($data['sitemap'])) {
                    $sitemap = new Sitemap();
                    $sitemap->slugId = $slug->id;
                    $sitemap->active = $data['sitemap']['active'] ?? false;
                    $sitemap->frequency = $data['sitemap']['frequency'] ?? 'daily';
                    $sitemap->priority = $data['sitemap']['priority'] ?? 0.5;
                    $sitemap->dateCreate = $data['sitemap']['dateCreate'];
                    $sitemap->dateUpdate = $data['sitemap']['dateUpdate'];
                    $sitemap->save(false);
                }
                return $slug;
            } else {
                return null;
            }
        }
        return null;
    }

    private function saveBlocs(ElementInterface $element, $data) {
        if (is_array($data)) {
            foreach ($data as $dataBloc) {
                $bloc = new Bloc();
                $bloc->blocTypeId = $dataBloc['blocTypeId'] ?? null;
                $bloc->save(false);
                $element->attachBloc($bloc, -1);

                foreach ($dataBloc as $attribute => $importValue) {

                    if( empty($importValue) === false && strpos($importValue, 'data:') === 0) {
                        $dataFile = $importValue;
                        $dataFiles = preg_split('/\s*,\s*/', $dataFile, -1, PREG_SPLIT_NO_EMPTY);
                        $prefix = trim(CoreModule::getInstance()->uploadFsPrefix, '/') . '/';
                        $fs = CoreModule::getInstance()->get('fs');
                        /* @var $fs Flysystem */
                        $uploadedFiles = [];
                        foreach ($dataFiles as $dataFile) {
                            if(empty($dataFiles) === false) {
                                [$type, $encoding, $name, $content] = preg_split('/\s*:\s*/', $dataFile, -1, PREG_SPLIT_NO_EMPTY);
                                if ($encoding === 'base64') {
                                    $dataContent = base64_decode($content);
                                    $targetFilename = '/bloc/'.$bloc->id.'/'.trim($name, '/');
                                    $fs->write($targetFilename, $dataContent);
                                    $uploadedFiles[] = $prefix.'/'.ltrim($targetFilename, '/');
                                }
                            }
                        }
                        $value = implode(', ', $uploadedFiles);
                        $bloc->setAttribute($attribute, $value);
                    } else {
                        $value =  $importValue ?? null;
                        $bloc->setAttribute($attribute, $value);
                    }

                }
                $bloc->save(false);
            }
        }
    }
    private function importComposite($data) {
        $transaction = CoreModule::getInstance()->db->beginTransaction();
        try {
            $slugData = $data['slug'] ?? null;
            $slug = $this->saveSlug($slugData);
            $composite = new Composite();
            $composite->name = $data['name'] ?? null;
            $composite->typeId = $data['typeId'] ?? null;
            $composite->slugId = $slug?->id;
            $composite->languageId = $data['languageId'] ?? 'en';
            $composite->active = $data['active'] ?? false;
            $composite->dateStart = $data['dateStart'] ?? null;
            $composite->dateEnd = $data['dateEnd'] ?? null;
            $composite->dateCreate = $data['dateCreate'] ?? null;
            $composite->dateUpdate = $data['dateUpdate'] ?? null;
            if ($composite->save(false)) {
                $blocs = $data['blocs'] ?? null;
                $this->saveBlocs($composite, $blocs);
                $tags = $data['tags'] ?? [];
                foreach ($tags as $tagId) {
                    $tag = Tag::find()->andWhere(['id' => $tagId])->one();
                    if ($tag !== null) {
                        $composite->attachTag($tag);
                    }
                }
                if (isset($data['nodes'][0])) {
                    $node = Node::find()->andWhere(['id' => $data['nodes'][0]])->one();
                    if ($node !== null) {
                        $nodeComposite = new NodeComposite();
                        $nodeComposite->compositeId = $composite->id;
                        CompositeHelper::handleNodes($composite, $nodeComposite);
                    }
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return $composite->id;
    }
    private function importNode($data) {
        $transaction = CoreModule::getInstance()->db->beginTransaction();
        try {
            $slugData = $data['slug'] ?? null;
            $slug = $this->saveSlug($slugData);
            $node = new Node();
            $node->name = $data['name'] ?? null;
            $node->typeId = $data['typeId'] ?? null;
            $node->slugId = $slug?->id;
            $node->languageId = $data['languageId'] ?? 'en';
            $node->active = $data['active'] ?? false;
            $node->dateStart = $data['dateStart'] ?? null;
            $node->dateEnd = $data['dateEnd'] ?? null;
            $node->dateCreate = $data['dateCreate'] ?? null;
            $node->dateUpdate = $data['dateUpdate'] ?? null;
            $parentId = $data['parentId'];
            $parentNode = Node::find()->andWhere(['id' => $parentId])->one();
            if ($parentNode === null) {
                $parentNode = Node::find()->orderBy(['left' => SORT_ASC])->one();
            }
            if ($node->saveInto($parentNode, false)) {
                $blocs = $data['blocs'] ?? null;
                $this->saveBlocs($node, $blocs);
                $tags = $data['tags'] ?? [];
                foreach ($tags as $tagId) {
                    $tag = Tag::find()->andWhere(['id' => $tagId])->one();
                    if ($tag !== null) {
                        $node->attachTag($tag);
                    }
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return $tag->id;
    }
    private function importTag($data) {
        $transaction = CoreModule::getInstance()->db->beginTransaction();
        try {
            $slugData = $data['slug'] ?? null;
            $slug = $this->saveSlug($slugData);
            $tag = new Tag();
            $tag->name = $data['name'] ?? null;
            $tag->typeId = $data['typeId'] ?? null;
            $tag->slugId = $slug?->id;;
            $tag->active = $data['active'] ?? false;
            $tag->dateCreate = $data['dateCreate'] ?? null;
            $tag->dateUpdate = $data['dateUpdate'] ?? null;
            $categoryId = $data['categoryId'] ?? null;
            if ($categoryId !== null) {
                $category = Category::find()->andWhere(['id' => $categoryId])->one();
            }
            if ($categoryId === null || $category === null) {
                throw new UnprocessableEntityHttpException('Unable to find category');
            }
            $tag->categoryId = $categoryId;
            if ($tag->save(false)) {
                $blocs = $data['blocs'] ?? null;
                $this->saveBlocs($tag, $blocs);
                $composites = $data['composites'] ?? [];
                foreach ($composites as $compositeId) {
                    $composite = Composite::find()->andWhere(['id' => $compositeId])->one();
                    if ($composite !== null) {
                        $composite->attachTag($tag);
                    }
                }
                $nodes = $data['nodes'] ?? [];
                foreach ($nodes as $nodeId) {
                    $node = Node::find()->andWhere(['id' => $nodeId])->one();
                    if ($node !== null) {
                        $node->attachTag($tag);
                    }
                }
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $node->id;
        }
        return true;
    }
    private function importCategory($data) {
        $transaction = CoreModule::getInstance()->db->beginTransaction();
        try {
            $slugData = $data['slug'] ?? null;
            $slug = $this->saveSlug($slugData);
            $category = new Category();
            $category->name = $data['name'] ?? null;
            $category->typeId = $data['typeId'] ?? null;
            $category->slugId = $slug?->id;
            $category->languageId = $data['languageId'] ?? 'en';
            $category->active = $data['active'] ?? false;
            $category->dateCreate = $data['dateCreate'] ?? null;
            $category->dateUpdate = $data['dateUpdate'] ?? null;

            if ($category->save(false)) {
                $blocs = $data['blocs'] ?? null;
                $this->saveBlocs($category, $blocs);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
        return $category->id;
    }
}
