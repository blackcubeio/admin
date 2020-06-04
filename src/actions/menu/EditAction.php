<?php
/**
 * EditAction.php
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

use blackcube\core\models\Language;
use blackcube\core\models\Menu;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\menu
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
