<?php
/**
 * DownItemAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */

namespace blackcube\admin\actions\menu;

use blackcube\admin\Module;
use blackcube\core\models\Language;
use blackcube\core\models\MenuItem;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DownItemAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */
class DownItemAction extends Action
{
    /**
     * @var string view
     */
    public $view = '_form_list';

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $menuItem = MenuItem::findOne(['id' => $id]);
        if ($menuItem === null) {
            throw new NotFoundHttpException();
        }
        $nextItem = MenuItem::find()
            ->andWhere(['parentId' => $menuItem->parentId])
            ->andWhere(['>', 'order', $menuItem->order])
            ->orderBy(['order' => SORT_ASC])
            ->one();
        $menu = $menuItem->menu;
        if ($nextItem !== null) {
            $nextOrder = $nextItem->order;
            $nextItem->order = $menuItem->order;
            $menuItem->order = $nextOrder;
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $menuItem->save(false, ['order', 'dateUpdate']);
                $nextItem->save(false, ['order', 'dateUpdate']);
                $transaction->commit();
                MenuItem::reorder($menu->id);
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        $menuItemsQuery = $menu->getChildren();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->controller->renderPartial($this->view, [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }
}
