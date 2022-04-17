<?php
/**
 * SeoAction.php
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
use blackcube\core\models\Bloc;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class SeoAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class SeoAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_seo';

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
                ->with('slug.seo')
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
        $seo = $element->slug->seo ?? Yii::createObject([
            'class' => Seo::class,
            'slugId' => $element->slug->id
        ]);
        $saved = null;
        if (Yii::$app->request->isPost) {
            $seo->scenario = Seo::SCENARIO_PRE_VALIDATE;
            $seo->load(Yii::$app->request->bodyParams);
            $transaction = Module::getInstance()->db->beginTransaction();
            if ($seo->save()) {
                $transaction->commit();
                $saved = true;
            } else {
                $transaction->rollBack();
                $saved = false;
            }
        }

        return $this->controller->renderPartial($this->view, [
            'element' => $element,
            'seo' => $seo,
            'saved' => $saved,
        ]);

    }
}
