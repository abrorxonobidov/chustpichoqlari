<?php

namespace common\models\other;

use common\models\base\LocalActiveRecord;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property int $status
 */
class Languages extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'languages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'title', 'status'], 'required'],
            [['status'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['title'], 'string', 'max' => 20],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
        ];
    }

    /**
     * {@inheritdoc}
     * @return LanguagesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LanguagesQuery(get_called_class());
    }
}
