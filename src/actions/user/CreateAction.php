<?php
/**
 * CreateAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\helpers\Tag as TagHelper;
use blackcube\admin\models\Administrator;
use blackcube\admin\models\SlugForm;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */
class CreateAction extends Action
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
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $user = Yii::createObject(Administrator::class);
        if (Yii::$app->request->isPost) {
            $user->setScenario(Administrator::SCENARIO_CREATE_ONLINE);
            $user->load(Yii::$app->request->bodyParams);
            if ($user->validate() === true) {
                $user->password = $user->newPassword;
                if ($user->save()) {
                    return $this->controller->redirect([$this->targetAction, 'id' => $user->id]);
                }
            }
            $user->checkPassword = '';
        }
        return $this->controller->render($this->view, [
            'user' => $user,
        ]);
    }
}
