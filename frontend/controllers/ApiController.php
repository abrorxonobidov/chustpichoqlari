<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02-Feb-20
 * Time: 01:36
 */

namespace frontend\controllers;


use common\components\DebugHelper;
use common\models\products\Products;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ApiController extends Controller
{

    public $enableCsrfValidation = false;

    static function allowedDomains()
    {
        return [
            'http://localhost:3000',
            'http://library.idesignedit.uz',
            'http://githubchustpichoqlari.uz/',
        ];
    }

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
     * @param $id
     * @return string|null
     * @throws NotFoundHttpException
     */
    public function actionProductView($id)
    {
        $headers = apache_request_headers();
        if (empty($headers['Origin']) || !in_array($headers['Origin'], static::allowedDomains()))
            throw new NotFoundHttpException('The requested page does not exist.');

        if (($product = $this->findProduct($id)) === null) {
            return null;
        }
        return Json::encode($product->attributes);
    }

    public function findProduct($id)
    {
        return Products::find()
            ->where([
                'id' => $id,
                'status' => 1
            ])
            ->one();
    }
}