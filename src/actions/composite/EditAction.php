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
 * @package blackcube\admin\actions\composite
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\models\SlugForm;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Type;
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
 * @package blackcube\admin\actions\composite
 */
class EditAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'form';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $composite = Composite::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $composite
        ]);
        $blocs = $composite->getBlocs()->all();
        $nodeComposite = NodeComposite::find()
            ->andWhere(['compositeId' => $composite->id])
            ->orderBy(['order' => SORT_ASC])
            ->one();
        if ($nodeComposite === null) {
            $nodeComposite = Yii::createObject(NodeComposite::class);
            $nodeComposite->compositeId = $composite->id;
        }

        // $result = $this->saveElement($composite, $blocs, $slugForm);
        $result = CompositeHelper::saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            CompositeHelper::handleTags($composite, $selectedTags);
            // $this->handleTags($composite, $selectedTags);
            CompositeHelper::handleNodes($composite, $nodeComposite);
            // $this->handleNodes($composite, $nodeComposite);
            return $this->controller->redirect(['edit', 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        // $selectTagsData =  $this->prepareTags();
        $selectTagsData =  CompositeHelper::prepareTags();
        $nodesQuery = Node::find()->orderBy(['left' => SORT_ASC]);

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
