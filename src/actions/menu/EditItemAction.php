<?php
/**
 * EditItemAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */

namespace blackcube\admin\actions\menu;

use blackcube\admin\helpers\Route as RouteHelper;
use blackcube\core\models\Menu;
use blackcube\core\models\MenuItem;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditItemAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */
class EditItemAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'form_item';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'edit';

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
        if (Yii::$app->request->isPost) {
            $menuItem->load(Yii::$app->request->bodyParams);
            if ($menuItem->validate() === true) {
                $dirtyAttributes = $menuItem->getDirtyAttributes();
                if (isset($dirtyAttributes['parentId']) === true) {
                    $reorder = true;
                    $menuItem->order = 999;
                } else {
                    $reorder = false;
                }
                try {
                    $transaction = MenuItem::getDb()->beginTransaction();
                    if ($menuItem->save() === true) {
                        if ($reorder === true) {
                            MenuItem::reorder($menuItem->menu->id);
                        }
                        $transaction->commit();
                        $this->controller->redirect([$this->targetAction, 'id' => $menuItem->menu->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }

        }
        $menu = Menu::find()->andWhere(['id' => $menuItem->menuId])->one();
        return $this->controller->render($this->view, [
            'menu' => $menuItem->menu,
            'menuItem' => $menuItem,
            'parents' => $this->getParents($menu, $menuItem->id),
            'routes' => RouteHelper::findAllRoutes(),
        ]);
    }

    private function getParents(Menu $menu, $menuItemId)
    {
        $menuItems = $menu->getChildren();
        $items = [];
        $level = 0;
        foreach($menuItems->each() as $menuItem) {
            /* @var \blackcube\core\models\MenuItem $menuItem */
            if ($menuItem->id !== $menuItemId) {
                $items[] = [
                    'id' => $menuItem->id,
                    'name' => $menuItem->name
                ];

                $items = ArrayHelper::merge($items, $this->buildSubMenuItems($menuItem, $level+1, $menuItemId));

            }
        }
        return $items;
    }
    private function buildSubMenuItems(MenuItem $menuItem, $level, $menuItemId)
    {
        $items = [];
        foreach ($menuItem->getChildren()->each() as $subMenuItem) {
            /* @var \blackcube\core\models\MenuItem $subMenuItem */
            if ($subMenuItem->id !== $menuItemId) {
                $items[] = [
                    'id' => $subMenuItem->id,
                    'name' => str_pad('', 2*$level, ' ', STR_PAD_LEFT).$subMenuItem->name,
                ];

                $items =  ArrayHelper::merge($items, $this->buildSubMenuItems($subMenuItem, $level+1, $menuItemId));

            }
        }
        return $items;
    }
}
