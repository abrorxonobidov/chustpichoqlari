<?php

namespace common\models\transactions;

use common\models\base\LocalActiveRecord;
use common\models\orders\Orders;

/**
 * This is the model class for table "transactions_click".
 *
 * @property int $id
 * @property int $order_id
 * @property int $click_trans_id
 * @property int $click_paydoc_id
 * @property int $service_id
 * @property int $amount
 * @property int $perform_time
 * @property int $cancel_time
 * @property int $status
 *
 * @property Orders $order
 */
class TransactionsClick extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions_click';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'click_trans_id', 'click_paydoc_id', 'service_id', 'perform_time'], 'required'],
            [['order_id', 'click_trans_id', 'click_paydoc_id', 'service_id', 'amount', 'status'], 'integer'],
            [['perform_time', 'cancel_time'], 'safe'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'click_trans_id' => 'Click Trans ID',
            'click_paydoc_id' => 'Click Paydoc ID',
            'service_id' => 'Service ID',
            'amount' => 'Amount',
            'perform_time' => 'Perform Time',
            'cancel_time' => 'Cancel Time',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     * @return TransactionsClickQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionsClickQuery(get_called_class());
    }
}
