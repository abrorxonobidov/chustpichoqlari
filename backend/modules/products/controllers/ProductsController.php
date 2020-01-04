<?php

namespace backend\modules\products\controllers;

use backend\controllers\BaseController;
use common\components\DebugHelper;
use common\models\prices\Prices;
use Yii;
use common\models\products\Products;
use common\models\products\ProductsSearch;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends BaseController
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        $model->order = 500;
        $model->price_currency_id = 860;
        $model->code = md5(microtime() . '+' . Yii::$app->user->id . '+' . mt_rand());
        if ($model->load(Yii::$app->request->post())) {
            $model->uploadImage('helpImage', 'image', 'prod');
            if ($model->save()) {
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
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException | mixed if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->uploadImage('helpImage', 'image', 'prod');
            if ($model->save()) {
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
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            $model->categoriesHelper = ArrayHelper::map(
                $model->categories,
                'id',
                'id'
            );
            if (($gallery = $model->gallery) !== null) {
                $model->galleryFolder = $gallery->folder;
            }
            if (($price = $model->price) !== null) {
                $model->price_amount = $price->amount;
                $model->price_discount_percent = $price->discount_percent;
                $model->price_discount_fixed = $price->discount_fixed;
                $model->price_currency_id = $price->currency_id;
            }
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('main', 'Sahifa mavjud emas'));
    }


    public function actionTest()
    {
        $ImagesArray = [];
        $file_display = ['jpg', 'jpeg', 'png', 'gif'];
        $dir = Yii::$app->params['galleryUploadPath'];
        $img = file_get_contents($dir);
        DebugHelper::printSingleObject($img);
        if (file_exists($dir) == false) {
            return ["Directory \'', $dir, '\' not found!"];
        } else {
            $dir_contents = scandir($dir);
            foreach ($dir_contents as $file) {
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($file_type, $file_display) == true) {
                    $ImagesArray[] = $file;
                }
            }
            print_r($ImagesArray);
        }
        return false;
    }

    /**
     * @return mixed
     * @throws mixed if the model cannot be found
     *
     */
    public function actionFileRemove()
    {
        $return = false;
        $file =
            Yii::$app->params['galleryUploadPath']
            . Yii::$app->request->post('key')
            . '/'
            . Yii::$app->request->post('imageName');
        if (isset($file) && file_exists($file)) {
            unlink($file);
            $return = true;
        }

        /*$id = Yii::$app->request->post('id');
        $count = Yii::$app->request->post('count');
        if ($count <= 1) {
            $model = Gallery::findOne(['product_id' => $id]);
            $model->delete();
        }*/
        return $return;
    }

    /**
     * Creates new Price model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException | mixed if the model cannot be found
     */
    public function actionEditPrice($id)
    {
        $product = $this->findModel($id);

        $new_price = new Prices();
        $new_price->product_id = $id;
        if (($old_price = $product->price) !== null) {
            $new_price->amount = $old_price->amount;
            $new_price->discount_percent = $old_price->discount_percent;
            $new_price->discount_fixed = $old_price->discount_fixed;
            $new_price->currency_id = $old_price->currency_id;
            $new_price->status = $old_price->status;
        };

        if ($new_price->load(Yii::$app->request->post())) {
            if ($new_price->save()){
                return $this->redirect(['view', 'id' => $new_price->product_id]);
            }else{
                DebugHelper::printSingleObject($new_price->errors, 1);
            }
        }

        return $this->render('../../../prices/views/prices/create', [
            'product' => $product,
            'model' => $new_price
        ]);

    }

}
