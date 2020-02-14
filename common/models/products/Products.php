<?php

namespace common\models\products;

use common\components\DebugHelper;
use common\models\base\LocalActiveRecord;
use common\models\orders\OrderProductLink;
use common\models\other\Gallery;
use common\models\prices\Prices;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $code
 * @property int $count
 * @property string $image
 * @property int $order
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $description_uz
 * @property string $description_ru
 * @property string $description_en
 * @property int $status
 *
 * @property array $categoriesHelper
 * @property array $galleryHelper
 * @property string $galleryFolder
 *
 * @property integer $price_amount
 * @property integer $price_discount_percent
 * @property integer $price_discount_fixed
 * @property integer $price_currency_id
 *
 * @property Gallery $gallery
 * @property OrderProductLink[] $orderProductLinks
 * @property Prices[] $prices
 * @property Prices $price
 * @property ProductCategoryLink[] $productCategoryLinks
 * @property ProductCategory[] $categories
 */
class Products extends LocalActiveRecord
{

    public $categoriesHelper;
    public $galleryHelper;
    public $galleryFolder;

    public $price_amount;
    public $price_currency_id;
    public $price_discount_percent;
    public $price_discount_fixed;

    /**
     * @param boolean $insert
     * @param array $changedAttributes
     * @throws mixed
     * @return boolean
     */
    public function afterSave($insert, $changedAttributes)
    {

        if (!$insert)
            foreach ($this->productCategoryLinks as $productCategoryLinks) {
                $productCategoryLinks->delete();
            }

        if (!empty($this->categoriesHelper))
            foreach ($this->categoriesHelper as $key => $category_id) {
                $product_category_link = new ProductCategoryLink();
                $product_category_link->product_id = $this->id;
                $product_category_link->product_category_id = $category_id;
                $product_category_link->order = $key;
                if (!$product_category_link->save()) {
                    DebugHelper::printSingleObject($product_category_link->errors, 1);
                }
            }

        /** Uploads gallery files*/
        $this->uploadGallery();

        $price = new Prices();
        $price->product_id = $this->id;
        $price->amount = $this->price_amount;
        $price->discount_percent = $this->price_discount_percent;
        $price->discount_fixed = $this->price_discount_fixed;
        $price->currency_id = $this->price_currency_id;
        $price->status = 1;
        if (!$price->save()) {
            DebugHelper::printSingleObject($price->errors, 1);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'count', 'order', 'title_uz', 'status', 'categoriesHelper', 'price_amount', 'price_currency_id'], 'required'],
            [['count', 'order', 'status'], 'integer'],
            [['price_amount', 'price_discount_fixed', 'price_currency_id'], 'integer'],
            [['price_discount_percent'], 'string'],
            [['code', 'image', 'galleryFolder'], 'string', 'max' => 50],
            [['code'], 'unique'],
            [['categoriesHelper', 'galleryHelper'], 'safe'],
            [['title_uz', 'title_ru', 'title_en'], 'string', 'max' => 255],
            [['description_uz', 'description_ru', 'description_en'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
                'code' => Yii::t('main', 'Kod'),
                'count' => Yii::t('main', 'Soni'),
                'categoriesHelper' => Yii::t('main', 'Kategoriyalar'),
                'galleryHelper' => Yii::t('main', 'Galeriya'),
                'price_amount' => Yii::t('main', 'Mahsulot narxi'),
                'price_discount_percent' => Yii::t('main', 'Chegirma foizda (%)'),
                'price_discount_fixed' => Yii::t('main', 'Chegirma aniq summa'),
                'price_currency_id' => Yii::t('main', 'Pul birligi')
            ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProductLinks()
    {
        return $this->hasMany(OrderProductLink::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Prices::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Prices::class, ['product_id' => 'id'])
            ->onCondition(['prices.status' => 1])
            ->orderBy(['prices.id' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategoryLinks()
    {
        return $this->hasMany(ProductCategoryLink::class, ['product_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }

    /**
     * @throws mixed
     */
    public function getCategories()
    {
        return $this->hasMany(ProductCategory::class, ['id' => 'product_category_id'])
            ->viaTable(ProductCategoryLink::tableName(), ['product_id' => 'id']);
    }


    public function getAllCategories()
    {
        return
            ArrayHelper::map(
                (new ProductCategorySearch())->search(['ProductCategorySearch' => ['status' => 1]])->getModels(),
                'id',
                'titleLang'
            );
    }


    public function inputGalleryConfig()
    {
        $config = [
            'path' => [],
            'config' => []
        ];
        if (!$this->isNewRecord && !empty($this->galleryFolder)) {

            $files = glob(Yii::$app->params['galleryUploadPath'] . $this->galleryFolder . "/{*.jpg,*.jpeg,*.gif,*.png}", GLOB_BRACE);

            foreach ($files as $file) {
                $filePath = explode('/', $file);
                $imageName = end($filePath);
                if (file_exists($file)) {
                    $config['path'][] = Url::to(self::imageSourcePath() . 'gallery/' . $this->galleryFolder . '/' . $imageName);
                    $config['config'][] = [
                        'caption' => $imageName,
                        'size' => filesize($file),
                        'url' => Url::to(['/products/products/file-remove']),
                        'key' => $this->galleryFolder,
                        'extra' => [
                            'id' => $this->id,
                            'count' => count($files),
                            'imageName' => $imageName
                        ],
                    ];
                }
            }
        }
        return $config;
    }

    /**
     * Uploads given image by post request
     */
    public function uploadGallery()
    {
        $images = UploadedFile::getInstances($this, 'galleryHelper');
        if ($images) {
            if (empty($this->galleryFolder) || $this->isNewRecord) {
                $folderName = self::createGuid();
                $gallery = new Gallery();
                $gallery->product_id = $this->id;
                $gallery->folder = $folderName;
                $gallery->order = 500;
                $gallery->status = 1;
                if (!$gallery->save()) {
                    DebugHelper::printSingleObject($gallery->errors);
                };
            } else {
                $folderName = $this->galleryFolder;
            }
            foreach ($images as $image) {
                if (empty($image)) continue;
                $imageName = self::createGuid() . '.' . $image->getExtension();
                $folderPath = self::uploadImagePath() . 'gallery/' . $folderName;
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }
                $imagePath = $folderPath . '/' . $imageName;

                $image->saveAs($imagePath);
                /*if(file_exists($imagePath)){
                    list($width, $height) = getimagesize($imagePath);
                    if(($width > $imageWidth && $height > $imageHeigth) || ($height > $imageWidth && $width > $imageHeigth)){
                        $resize = new ResizeImage($imagePath);
                        $resize->resizeTo($imageWidth, $imageWidth);
                        unlink($imagePath);
                        $resize->saveImage($imagePath,80);
                    }
                }*/
            }
        }
    }

}
