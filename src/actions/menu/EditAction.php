<?php
/**
 * EditAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\menu;

use blackcube\core\models\Language;
use blackcube\core\models\Menu;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class EditAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'form';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'edit';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $menu = Menu::findOne(['id' => $id]);
        if ($menu === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost === true) {
            $menu->load(Yii::$app->request->bodyParams);
            if ($menu->validate() === true) {
                if ($menu->save() === true) {
                    return $this->controller->redirect([$this->targetAction, 'id' => $menu->id]);
                }
            }
        }
        $menuItemsQuery = $menu->getChildren();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->controller->render($this->view, [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }
}
