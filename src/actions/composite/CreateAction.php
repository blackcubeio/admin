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
 * @package blackcube\admin\actions\composite
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\models\FilterActiveQuery;
use blackcube\admin\models\SlugForm;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
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
     * @var callable
     */
    public $typesQuery;

    /**
     * @var callable
     */
    public $nodesQuery;

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $composite = Yii::createObject(Composite::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $composite
        ]);
        $blocs = $composite->getBlocs()->all();
        $nodeComposite = Yii::createObject(NodeComposite::class);
        $result = CompositeHelper::saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            $nodeComposite->compositeId = $composite->id;
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            CompositeHelper::handleTags($composite, $selectedTags);
            CompositeHelper::handleNodes($composite, $nodeComposite);
            return $this->controller->redirect([$this->targetAction, 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = null;
        if (is_callable($this->typesQuery) === true) {
            $typesQuery = call_user_func($this->typesQuery);
        }
        if ($typesQuery === null || (($typesQuery instanceof ActiveQuery) === false)) {
            $typesQuery = Type::find();
        }
        $typesQuery->orderBy(['name' => SORT_ASC]);

        $selectTagsData =  CompositeHelper::prepareTags();

        $nodesQuery = null;
        if (is_callable($this->nodesQuery) === true) {
            $nodesQuery = call_user_func($this->nodesQuery);
        }
        if ($nodesQuery === null || (($nodesQuery instanceof ActiveQuery) === false)) {
            $nodesQuery = Node::find();
        }
        $nodesQuery->orderBy(['left' => SORT_ASC]);

        return $this->controller->render($this->view, [
            'composite' => $composite,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'nodesQuery' => $nodesQuery,
            'nodeComposite' => $nodeComposite,
            'selectTagsData' => $selectTagsData,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);

    }
}
