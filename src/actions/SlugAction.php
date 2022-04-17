<?php
/**
 * SlugAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */

namespace blackcube\admin\actions;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class SlugAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
class SlugAction extends Action
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_slug';

    /**
     * @var string
     */
    public $deleteView = '@blackcube/admin/views/common/_slug_delete';
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
                ->with('slug')
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
        $slug = $element->slug ?? Yii::createObject(Slug::class);
        $standalone = ($element instanceof Slug);
        $saved = null;
        if (Yii::$app->request->isPost) {
            $slug->load(Yii::$app->request->bodyParams);
            $shouldDelete = Yii::$app->request->getBodyParam('slugDelete', null);
            if ($shouldDelete !== null && $shouldDelete == $slug->id) {
                $element->detachSlug();
                return $this->controller->renderPartial($this->deleteView, [
                    'slugId' => $shouldDelete
                ]);
            }
            $transaction = Module::getInstance()->db->beginTransaction();
            if ($slug->save()) {
                if ($element->slug === null) {
                    $element->attachSlug($slug);
                }
                $transaction->commit();
                $saved = true;
                // detachSlug ???
            } else {
                $transaction->rollBack();
                $saved = false;
            }
        }

        return $this->controller->renderPartial($this->view, [
            'element' => $element,
            'slug' => $slug,
            'standalone' => $standalone,
            'saved' => $saved,
        ]);

    }
}
