<?php

namespace common\models\lists;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "lists_category".
 *
 * @property int $id
 * @property int $order
 * @property int $status
 *
 * @property ListsCategoryLang $currentLang
 *
 * @property Lists[] $lists
 * @property ListsCategoryLang[] $listsCategoryLangs
 *
 * @property string $lang_uz
 * @property string $lang_ru
 * @property string $lang_en
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $description_uz
 * @property string $description_ru
 * @property string $description_en
 * @property integer $status_uz
 * @property integer $status_ru
 * @property integer $status_en
 */
class ListsCategory extends LocalActiveRecord
{

    public $lang_uz;
    public $lang_ru;
    public $lang_en;
    public $title_uz;
    public $title_ru;
    public $title_en;
    public $description_uz;
    public $description_ru;
    public $description_en;
    public $status_uz;
    public $status_ru;
    public $status_en;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lists_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order', 'status'], 'integer'],
            [['order', 'status', 'title_uz'], 'required'],
            [
                [
                    'lang_uz',
                    'lang_ru',
                    'lang_en',
                    'title_uz',
                    'title_ru',
                    'title_en',
                    'description_uz',
                    'description_ru',
                    'description_en',
                    'status_uz',
                    'status_ru',
                    'status_en',
                ], 'string',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'order' => Yii::t('main', 'Tartibi'),
            'status' => Yii::t('main', 'Holati'),
            'title' => Yii::t('main', 'Nomi'),
            'description' => Yii::t('main', 'Izoh'),
            'lang_uz' => Yii::t('main', 'Til') . ' uz',
            'lang_ru' => Yii::t('main', 'Til') . ' ru',
            'lang_en' => Yii::t('main', 'Til') . ' en',
            'title_uz' => Yii::t('main', 'Nomi') . ' uz',
            'title_ru' => Yii::t('main', 'Nomi') . ' ru',
            'title_en' => Yii::t('main', 'Nomi') . ' en',
            'description_uz' => Yii::t('main', 'Izoh') . ' uz',
            'description_ru' => Yii::t('main', 'Izoh') . ' ru',
            'description_en' => Yii::t('main', 'Izoh') . ' en',
            'status_uz' => Yii::t('main', 'Holati') . ' uz',
            'status_ru' => Yii::t('main', 'Holati') . ' ru',
            'status_en' => Yii::t('main', 'Holati') . ' en'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLists()
    {
        return $this->hasMany(Lists::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListsCategoryLangs()
    {
        return $this->hasMany(ListsCategoryLang::className(), ['parent_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ListsCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListsCategoryQuery(get_called_class());
    }

    public function getCurrentLang(){
        return $this->hasOne(ListsCategoryLang::className(), ['parent_id' => 'id'])
            ->onCondition(['lang' => Yii::$app->language]);
    }

}
