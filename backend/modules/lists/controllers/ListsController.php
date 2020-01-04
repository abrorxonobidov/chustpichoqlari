<?php

namespace backend\modules\lists\controllers;

use backend\controllers\BaseController;
use common\components\DebugHelper;
use common\models\lists\ListsLang;
use Yii;
use common\models\lists\Lists;
use common\models\lists\ListsSearch;
use yii\web\NotFoundHttpException;

/**
 * ListsController implements the CRUD actions for Lists model.
 */
class ListsController extends BaseController
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
     * Lists all Lists models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ListsSearch();
        $dataProvider = $searchModel->searchLang(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Lists model.
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
     * Creates a new Lists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lists();
        $model->order = 500;
        if ($model->load(Yii::$app->request->post())) {
            $model->uploadImage('helpPreviewImage', 'preview_image', 'lists');
            $model->uploadImage('helpDescriptionImage', 'description_image', 'lists');
            if ($model->save()) {
                foreach ($model->getLanguages() as $lang) {
                    if (empty($model->{'title_' . $lang}) && empty($model->{'preview_' . $lang}) && empty($model->{'description_' . $lang})) continue;
                    $modelLang = new ListsLang();
                    $modelLang->parent_id = $model->id;
                    $modelLang->lang = $lang;
                    $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                    $modelLang->preview = $model->{'preview_' . $lang};
                    $modelLang->description = $model->{'description_' . $lang};
                    if (!$modelLang->save()) {
                        DebugHelper::printSingleObject($modelLang->errors, 1);
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                DebugHelper::printSingleObject($model->errors, 1);
            }

        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->uploadImage('helpPreviewImage', 'preview_image', 'lists');
            $model->uploadImage('helpDescriptionImage', 'description_image', 'lists');
            if ($model->save()) {
                foreach ($model->getLanguages() as $lang) {
                    if (($modelLang = ListsLang::findOne(['parent_id' => $model->id, 'lang' => $lang])) !== null) {
                        $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                        $modelLang->preview = $model->{'preview_' . $lang};
                        $modelLang->description = $model->{'description_' . $lang};
                        if (!$modelLang->save()) {
                            DebugHelper::printSingleObject($modelLang->errors, 1);
                        }
                    } else {
                        if (!empty($model->{'title_' . $lang}) || !empty($model->{'description_' . $lang})) {
                            $modelLang = new ListsLang();
                            $modelLang->parent_id = $model->id;
                            $modelLang->lang = $lang;
                            $modelLang->title = empty($model->{'title_' . $lang}) ? $model->title_uz : $model->{'title_' . $lang};
                            $modelLang->preview = $model->{'preview_' . $lang};
                            $modelLang->description = $model->{'description_' . $lang};
                            if (!$modelLang->save()) {
                                DebugHelper::printSingleObject($modelLang->errors, 1);
                            }
                        } else {
                            continue;
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                DebugHelper::printSingleObject($model->errors, 1);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lists model.
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
     * Finds the Lists model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lists the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lists::findOne($id)) !== null) {
            foreach ($model->getLanguages() as $lang) {
                if (($modelLang = ListsLang::findOne(['parent_id' => $model->id, 'lang' => $lang])) !== null) {
                    $model->{'title_' . $lang} = $modelLang->title;
                    $model->{'preview_' . $lang} = $modelLang->preview;
                    $model->{'description_' . $lang} = $modelLang->description;
                };
            }
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('main', 'Sahifa mavjud emas'));
    }

    public function actionFileRemove()
    {
        $return = false;
        $file = Yii::getAlias('@frontend') . '/web/uploads/' . Yii::$app->request->post('key');
        $id = Yii::$app->request->post('id');
        $field = Yii::$app->request->post('field');
        $className = Yii::$app->request->post('className');
        $model = $className::findOne($id);
        /** @var $model \yii\db\ActiveRecord*/
        $model->$field = '';
        $model->save(false);

        if (isset($file) && file_exists($file)) {
            unlink($file);
            $return = true;
        }
        return $return;
    }
}
