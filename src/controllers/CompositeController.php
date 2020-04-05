<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\models\TagManager;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Slug;
use blackcube\core\models\Language;
use blackcube\core\models\Type;
use blackcube\core\actions\ResumableUploadAction;
use blackcube\core\actions\ResumablePreviewAction;
use blackcube\core\actions\ResumableDeleteAction;
use yii\base\ErrorException;
use yii\base\Event;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class CompositeController extends BaseElementController
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Composite::class
        ];
        return $actions;
    }

    /**
     * @param string|null $id
     * @return string
     */
    public function actionIndex()
    {
        $compositesQuery = Composite::find()
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        return $this->render('index', [
            'compositesQuery' => $compositesQuery
        ]);
    }

    public function actionToggle($id = null)
    {
        if (Yii::$app->request->isAjax) {
            if ($id !== null) {
                $currentComposite = Composite::findOne(['id' => $id]);
                if ($currentComposite !== null) {
                    $currentComposite->active = !$currentComposite->active;
                    $currentComposite->save(false, ['active']);
                }
            }
            $compositesQuery = Composite::find()
                ->with('slug.seo')
                ->with('slug.sitemap')
                ->orderBy(['name' => SORT_ASC]);
            return $this->renderPartial('_list', [
                'compositesQuery' => $compositesQuery
            ]);
        }
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $composite = new Composite();
        $slugForm = new SlugForm(['element' => $composite]);
        $blocs = $composite->getBlocs()->all();
        $result = $this->saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['edit', 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'composite' => $composite,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id)
    {
        $composite = Composite::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = new SlugForm(['element' => $composite]);
        $blocs = $composite->getBlocs()->all();
        $result = $this->saveElement($composite, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['edit', 'id' => $composite->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'composite' => $composite,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $composite = Composite::findOne(['id' => $id]);
        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $composite->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $composite->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $composite->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->redirect(['index']);
    }

}
