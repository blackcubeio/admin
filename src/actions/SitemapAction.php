<?php
/**
 * SitemapAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */

namespace blackcube\admin\actions;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Sitemap;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class SitemapAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class SitemapAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_sitemap';

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
                ->with('slug.sitemap')
                ->one();
            if ($element === null) {
                throw new NotFoundHttpException();
            }
        } else {
            throw new NotFoundHttpException();
        }
        /**
         * @var $element ElementInterface
         */
        $sitemap = $element->slug->sitemap ?? Yii::createObject([
                'class' => Sitemap::class,
                'priority' => 0.5,
                'frequency' => 'daily',
                'slugId' => $element->slug->id,
            ]);
        $saved = null;
        if (Yii::$app->request->isPost) {
            $sitemap->scenario = Sitemap::SCENARIO_PRE_VALIDATE;
            $sitemap->load(Yii::$app->request->bodyParams);
            $transaction = Module::getInstance()->db->beginTransaction();
            if ($sitemap->save()) {
                $transaction->commit();
                $saved = true;
            } else {
                $transaction->rollBack();
                $saved = false;
            }
        }

        return $this->controller->renderPartial($this->view, [
            'element' => $element,
            'sitemap' => $sitemap,
            'frequencies' => array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY),
            'priorities' => array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY),
            'saved' => $saved,
        ]);

    }
}
