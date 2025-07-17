<?php
/**
 * UpItemAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\menu;

use blackcube\admin\Module;
use blackcube\core\models\MenuItem;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class UpItemAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
                $transaction = Module::getInstance()->get('db')->beginTransaction();
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
