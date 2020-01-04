<?php

namespace common\models\products;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property int $id
 * @property int $image
 * @property int $order
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $description_uz
 * @property string $description_ru
 * @property string $description_en
 * @property int $status
 *
 * @property string $helpImage
 *
 * @property string $title
 *
 * @property ProductCategoryLink[] $productCategoryLinks
 */
class ProductCategory extends LocalActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image'], 'string', 'max' => 50],
            [['order', 'status'], 'integer'],
            [['title_uz', 'title_ru', 'title_en'], 'string', 'max' => 255],
            [['description_uz', 'description_ru', 'description_en'], 'string'],
            [['order', 'title_uz', 'status'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategoryLinks()
    {
        return $this->hasMany(ProductCategoryLink::className(), ['product_category_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryQuery(get_called_class());
    }

}