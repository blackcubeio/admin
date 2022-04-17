<?php
/**
 * UpItemAction.php
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
 * Class UpItemAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */
class UpItemAction extends Action
{
    /**
     * @var string view
     */
    public $view = '_form_menu_items';

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
        $menu = $menuItem->menu;
        $previousItem = MenuItem::find()
            ->andWhere(['parentId' => $menuItem->parentId])
            ->andWhere(['<', 'order', $menuItem->order])
            ->andWhere(['menuId' => $menu->id])
            ->orderBy(['order' => SORT_DESC])
            ->one();
        if ($previousItem !== null) {
            $previousOrder = $previousItem->order;
            $previousItem->order = $menuItem->order;
            $menuItem->order = $previousOrder;
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $menuItem->save(false, ['order', 'dateUpdate']);
                $previousItem->save(false, ['order', 'dateUpdate']);
                $transaction->commit();
                MenuItem::reorder($menu->id);
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        $menuItemsQuery = $menu->getChildren();
        return $this->controller->renderPartial($this->view, [
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }
}
