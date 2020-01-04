<?php

namespace common\models\prices;

use common\models\base\LocalActiveRecord;
use common\models\products\Products;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "prices".
 *
 * @property int $id
 * @property int $product_id
 * @property int $amount
 * @property int $discount_percent
 * @property int $discount_fixed
 * @property int $status
 * @property int $currency_id
 *
 * @property int $actualAmount
 * @property array $currencyArray
 *
 * @property Products $product
 */
class Prices extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'amount', 'status'], 'required'],
            [['product_id', 'amount', 'discount_percent', 'discount_fixed', 'status', 'currency_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
                'product_id' => Yii::t('main', 'Mahsulot') . ' ID',
                'amount' => Yii::t('main', 'Narx'),
                'actualAmount' => Yii::t('main', 'Aktual narx'),
                'discount_percent' => Yii::t('main', 'Chegirma Foizda'),
                'discount_fixed' => Yii::t('main', 'Chegirma Muayyan'),
                'currency_id' => Yii::t('main', 'Pul birligi') . ' ID',
                'currency' => Yii::t('main', 'Pul birligi'),
            ];
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
     * @return PricesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PricesQuery(get_called_class());
    }

    public static function getCurrencyArray()
    {
        return [
            860 => [
                'id' => 860,
                'code' => 'UZS',
                'title' => 'So‘m',
                'short_title' => 'So‘m'
            ],
            840 => [
                'id' => 840,
                'code' => 'USD',
                'title' => 'AQSH dollari',
                'short_title' => 'Sh.b.'
            ],
            643 => [
                'id' => 643,
                'code' => 'RUB',
                'title' => 'Rossiya Rubli',
                'short_title' => 'Rubl'
            ]
        ];
    }

    public function getCurrency($key = 'short_title')
    {
        return $this->currencyArray[$this->currency_id][$key];
    }

    public static function getCurrencyList($key = 'short_title')
    {
        return ArrayHelper::map(
            self::getCurrencyArray(),
            'id',
            $key
        );
    }

    public function getActualAmount()
    {
        if ($this->discount_percent > 0) {
            return $this->amount * (1 - $this->discount_percent / 100);
        } elseif ($this->discount_fixed > 0) {
            return $this->amount - $this->discount_fixed;
        };
        return $this->amount;
    }

}
