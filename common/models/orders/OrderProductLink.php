<?php

namespace common\models\orders;

use common\models\base\LocalActiveRecord;
use common\models\products\Products;
use Yii;

/**
 * This is the model class for table "order_product_link".
 *
 * @property int $order_id
 * @property int $product_id
 * @property int $order
 * @property int $amount
 * @property int $count
 *
 * @property Orders $orders
 * @property Products $product
 */
class OrderProductLink extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_product_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'count'], 'required'],
            [['order_id', 'product_id', 'order', 'amount', 'count'], 'integer'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => Yii::t('main', 'Buyurtma').' ID',
            'product_id' => Yii::t('main', 'Mahsulot').' ID',
            'order' => Yii::t('main', 'Tartibi'),
            'amount' => Yii::t('main', 'Summa'),
            'count' => Yii::t('main', 'Soni'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return OrderProductLinkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderProductLinkQuery(get_called_class());
    }
}
