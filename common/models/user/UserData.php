<?php

namespace common\models\user;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_data".
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property int $birthday
 * @property string $phone
 * @property string $image
 * @property string $address
 * @property string $social_id
 * @property string $auth_type
 * @property int $role_id
 */
class UserData extends ActiveRecord
{

    const ROLE_CUSTOMER = 0 ;
    const ROLE_MODERATOR = 1 ;
    const ROLE_OWNER = 8 ;
    const ROLE_ADMIN = 9 ;
    const ROLE_SUPER_ADMIN = 10 ;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id'], 'required'],
            [['user_id', 'birthday', 'role_id'], 'integer'],
            [['first_name', 'last_name', 'social_id', 'middle_name', 'phone', 'image'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'user_id' => Yii::t('main', 'User ID'),
            'first_name' => Yii::t('main', 'Ism'),
            'last_name' => Yii::t('main', 'Familiya'),
            'middle_name' => Yii::t('main', 'Sharifi'),
            'birthday' => Yii::t('main', 'Tug\'ilgan sana'),
            'phone' => Yii::t('main', 'Telefon'),
            'image' => Yii::t('main', 'Rasm'),
            'address' => Yii::t('main', 'Manzil'),
            'social_id' => Yii::t('main', 'Ijt. tarm. ID'),
            'auth_type' => Yii::t('main', 'Avtorizatsiya turi'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserDataQuery(get_called_class());
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    public static function getRoles(){
        return [
            0 => 'Customer',
            1 => 'Moderator',
            8 => 'Owner',
            9 => 'Admin',
            10 => 'Super Admin'
        ];
    }
}
