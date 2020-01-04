<?php

namespace common\models\other;

use common\models\base\LocalActiveRecord;

/**
 * This is the model class for table "payment_systems".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $data
 * @property int $status
 * @property string $short_name
 * @property string $merchant_id
 * @property string $secret_key
 */
class PaymentSystems extends LocalActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_systems';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status'], 'required'],
            [['description', 'data'], 'string'],
            [['status'], 'integer'],
            [['title', 'merchant_id', 'secret_key'], 'string', 'max' => 255],
            [['short_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'data' => 'Data',
            'status' => 'Status',
            'short_name' => 'Short Name',
            'merchant_id' => 'Merchant ID',
            'secret_key' => 'Secret Key',
        ];
    }

    /**
     * {@inheritdoc}
     * @return PaymentSystemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentSystemsQuery(get_called_class());
    }
}
