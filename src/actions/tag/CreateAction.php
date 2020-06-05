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
 * @package blackcube\admin\actions\tag
 */

namespace blackcube\admin\actions\tag;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Tag as TagHelper;
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
 * @package blackcube\admin\actions\tag
 */
class CreateAction extends BaseElementAction
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
        $tag = Yii::createObject(Tag::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $tag,
        ]);
        $blocs = $tag->getBlocs()->all();
        $result = TagHelper::saveElement($tag, $blocs, $slugForm);
        if ($result === true) {
            return $this->controller->redirect([$this->targetAction, 'id' => $tag->id]);
        }
        $categoriesQuery = $this->getCategoriesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        return $this->controller->render($this->view, [
            'tag' => $tag,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
        ]);
    }
}
