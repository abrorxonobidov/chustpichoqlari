<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02-Feb-20
 * Time: 01:36
 */

namespace frontend\controllers;


use common\models\lists\Lists;
use common\models\lists\ListsCategory;
use common\models\products\Products;
use Yii;
use yii\db\ActiveQuery;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * @property boolean $enableCsrfValidation
 */
class ApiController extends Controller
{

    public $enableCsrfValidation = false;


    /**
     * @return array
     */
    private static function allowedDomains()
    {
        return [
            'http://localhost:3000',
            'http://githubchustpichoqlari.uz/',
        ];
    }


    /**
     * @return \common\models\lists\ListsQuery
     */
    private function getListQuery()
    {
        return Lists::find()
            ->with('lang')
            ->where(['status' => 1])
            ->asArray();
    }


    /**
     * @return \common\models\products\ProductsQuery
     */
    private function getProductQuery()
    {
        $lang = Yii::$app->language;
        return Products::find()
            ->select(
                "products.id,
                count,
                image,
                order,
                title_$lang as title,
                description_$lang as description
                "
            )
            ->with([
                'price' => function (ActiveQuery $query) {
                    $query->select('
                    id,
                    product_id, 
                    amount, 
                    discount_percent, 
                    discount_fixed, 
                    currency_id,
                    CASE 
                        WHEN (discount_percent > 0) THEN (amount * (1 - discount_percent / 100))
                        WHEN ((discount_percent <= 0 OR discount_percent IS NULL) AND discount_fixed > 0) THEN (amount - discount_fixed)
                        ELSE amount
                    END as actual_amount
                    ');
                },
                'gallery',
                'categoriesForApi',
            ])
            ->where(['products.status' => 1])
            ->asArray(true);
    }


    /**
     * @param $action
     * @return bool
     * @throws NotFoundHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');
        setcookie('cross-site-cookie', 'name', ['SameSite' => 'None', 'Secure' => true]);
        $headers = apache_request_headers();
        if (empty($headers['Origin']) || !in_array($headers['Origin'], static::allowedDomains()))
            throw new NotFoundHttpException('Page not found');
        return parent::beforeAction($action);
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['GET'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                ],
            ]
        ]);
    }


    /**
     * @param int|null $offset
     * @param int|null $limit
     * @return string
     */
    public function actionProductList($offset = 0, $limit = 20)
    {
        $products = $this->getProductQuery()
            ->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC])
            ->limit($limit)
            ->offset($offset)
            ->all();
        return Json::encode($products);
    }


    /**
     * @param $id
     * @return string|null
     */
    public function actionProductView($id)
    {
        $product = $this->getProductQuery()
            ->andWhere(['id' => $id])
            ->one();

            if (($galleryFolder = @$product['gallery']['folder']) !== null ) {
                $images = glob(Yii::$app->params['galleryUploadPath'] . $galleryFolder . "/{*.jpg,*.jpeg,*.gif,*.png}", GLOB_BRACE);
                $gallery = [];
                foreach ($images as $image) {
                    $filePath = explode('/', $image);
                    $fileName = end($filePath);
                    $gallery[] = 'gallery/' . $galleryFolder . '/' . $fileName;
                }
                $product['gallery_items'] = $gallery;

            };

        return Json::encode($product);
    }


    /**
     * @param $category_id
     * @param int|null $offset
     * @param int|null $limit
     * @return string
     */
    public function actionListsList($category_id, $offset = null, $limit = 0)
    {
        $lists = $this->getListQuery()
            ->andWhere(['category_id' => $category_id])
            ->orderBy(['order' => SORT_ASC, 'id' => SORT_DESC])
            ->offset($offset)
            ->limit($limit)
            ->all();
        return Json::encode($lists);
    }


    /**
     * @param $id int
     * @return string
     */
    public function actionListsView($id)
    {
        $list = $this->getListQuery()
            ->andWhere(['id' => $id])
            ->all();
        return Json::encode($list);
    }


    /**
     * @param $id integer
     * @return string
     */
    public function actionListsCategory($id)
    {
        $listsCategory = ListsCategory::find()
            ->with('lang')
            ->where(['id' => $id, 'status' => 1])
            ->asArray()
            ->one();
        return Json::encode($listsCategory);
    }


}