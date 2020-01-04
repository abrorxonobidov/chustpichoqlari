<?php

namespace common\models\lists;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "lists_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $lang
 * @property string $title
 * @property string $preview
 * @property string $description
 * @property int $status
 *
 * @property Lists $parent
 */
class ListsLang extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lists_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'lang', 'title'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['description'], 'string'],
            [['lang'], 'string', 'max' => 2],
            [['title', 'preview'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lists::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'parent_id' => Yii::t('main', 'Asosiy').' ID',
            'lang' => Yii::t('main', 'Til'),
            'title' => Yii::t('main', 'Nomi'),
            'preview' => Yii::t('main', 'Anons'),
            'description' => Yii::t('main', 'Batafsil'),
            'status' => Yii::t('main', 'Holati'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Lists::className(), ['id' => 'parent_id']);
    }

    /**
     * {@inheritdoc}
     * @return ListsLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListsLangQuery(get_called_class());
    }
}
