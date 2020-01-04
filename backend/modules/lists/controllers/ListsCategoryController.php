<?php

namespace backend\modules\lists\controllers;

use backend\controllers\BaseController;
use common\components\DebugHelper;
use common\models\lists\ListsCategoryLang;
use Yii;
use common\models\lists\ListsCategory;
use common\models\lists\ListsCategorySearch;
use yii\web\NotFoundHttpException;

/**
 * ListsCategoryController implements the CRUD actions for ListsCategory model.
 */
class ListsCategoryController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviour = [];

        return array_merge(parent::behaviors(), $behaviour);
    }

    /**
     * Lists all ListsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ListsCategorySearch();
        $dataProvider = $searchModel->searchLang(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ListsCategory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ListsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ListsCategory();
        $model->order = 500;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($model->getLanguages() as $lang) {
                if (empty($model->{'title_' . $lang}) && empty($model->{'description_' . $lang})) continue;
                $modelLang = new ListsCategoryLang();
                $modelLang->parent_id = $model->id;
                $modelLang->lang = $lang;
                $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                $modelLang->description = $model->{'description_' . $lang};
                if (!$modelLang->save()) {
                    DebugHelper::printSingleObject($modelLang->errors, 1);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ListsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        //TODO put scenario for title, that it should be required when it exists

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            foreach ($model->getLanguages() as $lang) {
                if (($modelLang = ListsCategoryLang::findOne(['parent_id' => $model->id, 'lang' => $lang])) !== null) {

                    $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                    $modelLang->description = $model->{'description_' . $lang};
                    $modelLang->status = 1;
                    if (!$modelLang->save()) {
                        DebugHelper::printSingleObject($modelLang->errors, 1);
                    }
                } else {
                    if (!empty($model->{'title_' . $lang}) || !empty($model->{'description_' . $lang})) {
                        $modelLang = new ListsCategoryLang();
                        $modelLang->parent_id = $model->id;
                        $modelLang->lang = $lang;
                        $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                        $modelLang->description = $model->{'description_' . $lang};
                        $modelLang->status = 1;
                        if (!$modelLang->save()) {
                            DebugHelper::printSingleObject($modelLang->errors, 1);
                        }
                    } else {
                        continue;
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ListsCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException | mixed if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ListsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ListsCategory::findOne($id)) !== null) {
            foreach ($model->getLanguages() as $lang) {
                if (($modelLang = ListsCategoryLang::findOne(['parent_id' => $model->id, 'lang' => $lang])) !== null) {
                    $model->{'title_' . $lang} = $modelLang->title;
                    $model->{'description_' . $lang} = $modelLang->description;
                };
            }
            return $model;
        }
        throw new NotFoundHttpException('Sahifa mavjud emas');
    }
}
