<?php

namespace common\models\orders;

use common\models\products\Products;
use common\models\transactions\TransactionsClick;
use common\models\transactions\TransactionsPayme;
use common\models\user\User;
use Yii;
use common\models\base\LocalActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property string $phone
 * @property int $status
 *
 * @property OrderProductLink[] $orderProductLinks
 * @property User $user
 * @property TransactionsClick[] $transactionsClicks
 * @property TransactionsPayme[] $transactionsPaymes
 * @property Products[] $products
 *
 */
class Orders extends LocalActiveRecord
{

    const STATUS_DRAFT = 1;
    const STATUS_CANCELLED = 3;
    const STATUS_PAID = 5;
    const STATUS_DELIVERED = 7;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'phone'], 'required'],
            [['user_id', 'amount', 'status'], 'integer'],
            [['phone'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
                'id' => Yii::t('main', 'ID'),
                'user_id' => Yii::t('main', 'Foydalanuvchi') . ' ID',
                'user_name_and_surname' => Yii::t('main', 'Foydalanuvchi'),
                'amount' => Yii::t('main', 'Summa'),
                'phone' => Yii::t('main', 'Telefon'),
                'status' => Yii::t('main', 'Holati'),
            ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProductLinks()
    {
        return $this->hasMany(OrderProductLink::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsClicks()
    {
        return $this->hasMany(TransactionsClick::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactionsPaymes()
    {
        return $this->hasMany(TransactionsPayme::class, ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }

    /**
     * @throws mixed
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['id' => 'product_id'])
            ->viaTable(OrderProductLink::tableName(), ['order_id' => 'id']);
    }

    public function getOrderProducts()
    {
        //todo improve this query
        return OrderProductLink::find()
            ->select([
                'p.id',
                'title' => 'p.title_' . Yii::$app->language,
                'o_p_l.amount',
                'o_p_l.count',
                'o_p_l.order',
            ])
            ->from(['o_p_l' => OrderProductLink::tableName()])
            ->innerJoin(['p' => Products::tableName()], 'o_p_l.product_id = p.id')
            ->where(['o_p_l.order_id' => $this->id])
            ->orderBy(['o_p_l.order' => SORT_ASC, 'id' => SORT_ASC])
            ->asArray()
            ->all();
    }

    public static function getOrderStatusList()
    {
        return [
            self::STATUS_DRAFT => [
                'title' => Yii::t('main', 'Qoralama'),
                'icon' => 'edit',
                'color' => '#ffff00'
            ],
            self::STATUS_CANCELLED => [
                'title' => Yii::t('main', 'Bekor qilingan'),
                'icon' => 'remove',
                'color' => '#ff0000'
            ],
            self::STATUS_PAID => [
                'title' => Yii::t('main', 'To‘lov o‘tkazilgan'),
                'icon' => 'dollar',
                'color' => '#0000ff'
            ],
            self::STATUS_DELIVERED => [
                'title' => Yii::t('main', 'Yetkazib berilgan'),
                'icon' => 'check-square',
                'color' => '#00ff00'
            ]
        ];
    }

    public static function getOrderStatusListForDropdown(){
        $statusList = [];
        foreach (Orders::getOrderStatusList() as $key => $status) {
            $statusList[$key] = $status['title'];
        };
        return $statusList;
    }

}
