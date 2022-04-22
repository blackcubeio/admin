<?php
/**
 * CreateItemAction.php
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
 * Class CreateItemAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
 */
class CreateItemAction extends Action
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
     * @param integer $menuId
     * @param MenuItem $menuItem
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($menuId, MenuItem $menuItem)
    {
        $menu = Menu::findOne(['id' => $menuId]);
        if ($menu === null) {
            throw new NotFoundHttpException();
        }
        $menuItem->menuId = $menuId;
        if (Yii::$app->request->isPost) {
            $menuItem->load(Yii::$app->request->bodyParams);
            if ($menuItem->validate() === true) {
                $menuItem->order = 999;
                try {
                    $transaction = MenuItem::getDb()->beginTransaction();
                    if ($menuItem->save() === true) {
                        MenuItem::reorder($menu->id);
                        $transaction->commit();
                        $this->controller->redirect([$this->targetAction, 'id' => $menu->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        // $parentsQuery = MenuItem::find()->andWhere(['menuId' => $menu->id]);
        return $this->controller->render($this->view, [
            'menu' => $menu,
            'menuItem' => $menuItem,
            'parents' => $this->getParents($menu),
            'routes' => RouteHelper::findAllRoutes(),
        ]);
    }

    private function getParents(Menu $menu)
    {
        $menuItems = $menu->getChildren();
        $items = [];
        $level = 0;
        foreach($menuItems->each() as $menuItem) {
            /* @var \blackcube\core\models\MenuItem $menuItem */
            $items[] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name
            ];

            $items = ArrayHelper::merge($items, $this->buildSubMenuItems($menuItem, $level++));

        }
        return $items;
    }
    private function buildSubMenuItems(MenuItem $menuItem, $level)
    {
        $items = [];
        foreach ($menuItem->getChildren()->each() as $subMenuItem) {
            /* @var \blackcube\core\models\MenuItem $subMenuItem */
            $items[] = [
                'id' => $subMenuItem->id,
                'name' => str_pad('', 2*$level, ' ', STR_PAD_LEFT).$subMenuItem->name,
            ];

            $items =  ArrayHelper::merge($items, $this->buildSubMenuItems($subMenuItem, $level++));

        }
        return $items;
    }
}
