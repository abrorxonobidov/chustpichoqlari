<?php

namespace common\models\base;

use common\models\user\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "logs".
 *
 * @property int $table
 * @property int $user_id
 * @property int $action_id
 * @property int $row_id
 * @property string $date
 *
 * @property User $user
 */
class Logs extends ActiveRecord
{

    const ACTION_INSERT = 1;
    const ACTION_UPDATE = 2;
    const ACTION_DELETE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table', 'user_id', 'action_id'], 'required'],
            [['user_id', 'action_id', 'row_id'], 'integer'],
            [['date'], 'safe'],
            [['table'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'table' => 'Table',
            'user_id' => 'User ID',
            'action_id' => 'Action ID',
            'row_id' => 'Row ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @return array
     */
    public static function getActionList(){
        return [
            self::ACTION_INSERT => 'Insert',
            self::ACTION_UPDATE => 'Update',
            self::ACTION_DELETE => 'Delete'
        ];
    }

    /**
     * {@inheritdoc}
     * @return LogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogsQuery(get_called_class());
    }
}
