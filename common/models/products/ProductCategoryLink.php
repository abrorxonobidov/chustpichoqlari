<?php

namespace common\models\products;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "product_category_link".
 *
 * @property int $product_id
 * @property int $product_category_id
 * @property int $order
 *
 * @property ProductCategory $productCategory
 * @property Products $product
 */
class ProductCategoryLink extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_category_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'product_category_id'], 'required'],
            [['product_id', 'product_category_id', 'order'], 'integer'],
            [['product_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::className(), 'targetAttribute' => ['product_category_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('main', 'Mahsulot').' ID',
            'product_category_id' => Yii::t('main', 'Mahsulot kategoriyasi').' ID',
            'order' => Yii::t('main', 'Tartibi'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductCategoryLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductCategoryLinkQuery(get_called_class());
    }
}
