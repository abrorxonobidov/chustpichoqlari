<?php

namespace common\models\lists;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "lists_category_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $lang
 * @property string $title
 * @property string $description
 * @property int $status
 *
 * @property ListsCategory $parent
 */
class ListsCategoryLang extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lists_category_lang';
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
            [['title'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ListsCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'description' => Yii::t('main', 'Izoh'),
            'status' => Yii::t('main', 'Holati'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ListsCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * {@inheritdoc}
     * @return ListsCategoryLangQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListsCategoryLangQuery(get_called_class());
    }
}
