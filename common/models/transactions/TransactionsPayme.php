<?php

namespace common\models\transactions;

use common\models\base\LocalActiveRecord;
use common\models\orders\Orders;
use Yii;

/**
 * This is the model class for table "transactions_payme".
 *
 * @property int $id
 * @property int $order_id
 * @property string $paycom_transaction_id
 * @property int $amount
 * @property int $reason
 * @property string $receivers JSON array of receivers
 * @property string $paycom_time
 * @property string $paycom_time_datetime
 * @property string $create_time
 * @property string $perform_time
 * @property string $cancel_time
 * @property int $status
 *
 * @property Orders $order
 */
class TransactionsPayme extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions_payme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'paycom_transaction_id', 'amount', 'paycom_time', 'paycom_time_datetime', 'create_time'], 'required'],
            [['order_id', 'amount', 'reason', 'status'], 'integer'],
            [['paycom_time_datetime', 'create_time', 'perform_time', 'cancel_time'], 'safe'],
            [['paycom_transaction_id'], 'string', 'max' => 25],
            [['receivers'], 'string', 'max' => 500],
            [['paycom_time'], 'string', 'max' => 13],
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
            'paycom_transaction_id' => 'Paycom Transaction ID',
            'amount' => 'Amount',
            'reason' => 'Reason',
            'receivers' => 'Receivers',
            'paycom_time' => 'Paycom Time',
            'paycom_time_datetime' => 'Paycom Time Datetime',
            'create_time' => 'Create Time',
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
     * @return TransactionsPaymeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionsPaymeQuery(get_called_class());
    }
}
