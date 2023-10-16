<?php
/**
 * ExportAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */

namespace blackcube\admin\actions;

use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use blackcube\core\Module;
use blackcube\core\components\Flysystem;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Seo;
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ExportAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class ExportAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

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
            $elementType = $elementClass::getElementType();
            $elementQuery = $elementClass::find()
                ->andWhere(['id' => $id]);
            switch ($elementType) {
                case Composite::ELEMENT_TYPE:
                    $elementQuery->with(['blocs', 'slug.seo', 'slug.sitemap', 'tags', 'nodes']);
                    break;
                case Node::ELEMENT_TYPE:
                    $elementQuery->with(['blocs', 'slug.seo', 'slug.sitemap', 'tags', 'composites']);
                    break;
                case Category::ELEMENT_TYPE:
                    $elementQuery->with(['blocs', 'slug.seo', 'slug.sitemap', 'tags']);
                    break;
                case Tag::ELEMENT_TYPE:
                    $elementQuery->with(['blocs', 'slug.seo', 'slug.sitemap', 'nodes', 'composites']);
                    break;
                default:
                    throw new NotFoundHttpException();
            }

            $element = $elementQuery->one();
            if ($element === null) {
                throw new NotFoundHttpException();
            }
            $elementData = $this->exportElement($element);
            if ($elementData !== null) {
                switch ($elementType) {
                    case Composite::ELEMENT_TYPE:
                        foreach ($element->tags as $tag) {
                            $elementData['tags'][] = $tag->id;
                        }
                        foreach ($element->nodes as $node) {
                            $elementData['nodes'][] = $node->id;
                        }
                        break;
                    case Node::ELEMENT_TYPE:
                        foreach ($element->tags as $tag) {
                            $elementData['tags'][] = $tag->id;
                        }
                        foreach ($element->composites as $composite) {
                            $elementData['composites'][] = $composite->id;
                        }
                        break;
                    case Category::ELEMENT_TYPE:
                        foreach ($element->tags as $tag) {
                            $elementData['tags'][] = $tag->id;
                        }
                        break;
                    case Tag::ELEMENT_TYPE:
                        foreach ($element->nodes as $node) {
                            $elementData['nodes'][] = $node->id;
                        }
                        foreach ($element->composites as $composite) {
                            $elementData['composites'][] = $composite->id;
                        }
                        break;
                    default:
                        throw new NotFoundHttpException();
                }
            }
        } else {
            throw new NotFoundHttpException();
        }
        Yii::$app->response->sendContentAsFile(
            Json::encode($elementData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $elementClass::getElementType().'-'.$id.'.json', [
            'mimeType' => 'application/json',
        ]);
    }

    private function exportSitemap($sitemap)
    {
        $sitemapData = null;
        if ($sitemap !== null) {
            $sitemapData = $sitemap->toArray();
            unset($sitemapData['id']);
        }
        return $sitemapData;
    }
    private function exportSeo($seo)
    {
        $seoData = null;
        if ($seo !== null) {
            $seoData = $seo->toArray();
            unset($seoData['id']);
            if ($seoData['slugId'] === $seoData['canonicalSlugId']) {
                $seoData['canonical'] = true;
            } else if (empty($seoData['canonicalSlugId'])) {
                $seoData['canonical'] = false;
            } else {
                $slug = Slug::find()->andWhere(['id' => $seoData['canonicalSlugId']])->one();
                if ($slug !== null) {
                    $seoData['canonical'] = $slug->path;
                }
            }
            unset($seoData['slugId']);
            unset($seoData['canonicalSlugId']);
        }
        return $seoData;
    }
    private function exportSlug($slug) {
        $slugData = null;
        if ($slug !== null) {
            $slugData = $slug->toArray();
            unset($slugData['id']);
            unset($slugData['targetUrl']);
            unset($slugData['httpCode']);
            $seoData = $this->exportSeo($slug->seo);
            if ($seoData !== null) {
                $slugData['seo'] = $seoData;
            }
            $sitemapData = $this->exportSitemap($slug->sitemap);
            if ($sitemapData !== null) {
                $slugData['sitemap'] = $sitemapData;
            }
        }
        return $slugData;
    }
    private function exportBlocs($blocs) {
        $prefix = trim(Module::getInstance()->uploadFsPrefix, '/') . '/';
        $blocsData = [];
        if (is_array($blocs)) {
            foreach ($blocs as $bloc) {
                $elasticAttributes = $bloc->getElasticAttributes();
                $blocData = $bloc->toArray();
                unset($blocData['data']);
                unset($blocData['id']);
                foreach ($elasticAttributes as $elasticAttribute => $value) {
                    if (empty($value) === false) {
                        $splitted = preg_split('/\s*,\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
                        $converted = [];
                        foreach ($splitted as $splitValue) {
                            if (strncmp($prefix, $splitValue, strlen($prefix)) === 0) {
                                $fs = Module::getInstance()->get('fs');
                                /* @var $fs Flysystem */
                                $originalFilename = str_replace($prefix, '', $splitValue);
                                $fileName = pathinfo($originalFilename, PATHINFO_BASENAME);
                                if ($fs->fileExists($originalFilename) === true) {
                                    $fileData = $fs->read($originalFilename);
                                    $converted[] = 'data:base64:' . $fileName . ':' . base64_encode($fileData);
                                } else {
                                    $converted[] = 'notfound:' . $fileName . ':' . $splitValue;
                                }
                            } else {
                                $converted[] = $splitValue;
                            }
                        }
                        $blocData[$elasticAttribute] = implode(', ', $converted);
                    } else {
                        $blocData[$elasticAttribute] = null;
                    }
                }
                $blocsData[] = $blocData;
            }
        }
        return empty($blocsData) ? null : $blocsData;
    }
    private function exportElement($element)
    {
        $elementData = null;
        if ($element !== null) {
            $elementData['elementType'] = $element::getElementType();
            $elementData = array_merge($elementData, $element->toArray());
            if ($element instanceof Node) {
                $parent = $element->getParent()->one();
                if ($parent !== null) {
                    $elementData['parentId'] = $parent->id;
                }
            }

            unset($elementData['id']);

            unset ($elementData['slugId']);
            $slugData = $this->exportSlug($element->slug);
            if ($slugData !== null) {
                $elementData['slug'] = $slugData;
            }
            $blocsData = $this->exportBlocs($element->blocs);
            if ($blocsData !== null) {
                $elementData['blocs'] = $blocsData;
            }
        }
        return $elementData;
    }
}
