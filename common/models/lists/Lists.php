<?php

namespace common\models\lists;

use common\models\base\LocalActiveRecord;
use Yii;

/**
 * This is the model class for table "lists".
 *
 * @property int $id
 * @property int $category_id
 * @property string $date
 * @property int $order
 * @property string $preview_image
 * @property string $description_image
 * @property int $status
 *
 * @property string $lang_uz
 * @property string $lang_ru
 * @property string $lang_en
 * @property string $title_uz
 * @property string $title_ru
 * @property string $title_en
 * @property string $preview_uz
 * @property string $preview_ru
 * @property string $preview_en
 * @property string $description_uz
 * @property string $description_ru
 * @property string $description_en
 * @property integer $status_uz
 * @property integer $status_ru
 * @property integer $status_en
 *
 * @property integer $helpPreviewImage
 * @property integer $helpDescriptionImage
 *
 * @property ListsCategory $category
 * @property ListsLang[] $listsLangs
 */
class Lists extends LocalActiveRecord
{

    public $lang_uz;
    public $lang_ru;
    public $lang_en;
    public $title_uz;
    public $title_ru;
    public $title_en;
    public $preview_uz;
    public $preview_ru;
    public $preview_en;
    public $description_uz;
    public $description_ru;
    public $description_en;
    public $status_uz;
    public $status_ru;
    public $status_en;

    public $helpPreviewImage;
    public $helpDescriptionImage;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'order', 'status'], 'integer'],
            [['date', 'category_id', 'status', 'title_uz', 'order'], 'required'],
            [['date'], 'safe'],
            [['preview_image', 'description_image'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ListsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [
                [
                    'lang_uz',
                    'lang_ru',
                    'lang_en',
                    'title_uz',
                    'title_ru',
                    'title_en',
                    'preview_uz',
                    'preview_ru',
                    'preview_en',
                    'description_uz',
                    'description_ru',
                    'description_en',
                    'status_uz',
                    'status_ru',
                    'status_en',
                    'helpPreviewImage',
                    'helpDescriptionImage',
                ], 'string',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return parent::attributeLabels() + [
            'date' => Yii::t('main', 'Sana'),
            'preview_image' => Yii::t('main', 'Anons rasm'),
            'helpPreviewImage' => Yii::t('main', 'Anons rasm'),
            'description_image' => Yii::t('main', 'Batafsil rasm'),
            'helpDescriptionImage' => Yii::t('main', 'Batafsil rasm'),
            'preview' => Yii::t('main', 'Anons'),
            'preview_uz' => Yii::t('main', 'Anons') . ' uz',
            'preview_ru' => Yii::t('main', 'Anons') . ' ru',
            'preview_en' => Yii::t('main', 'Anons') . ' en',
            'status_uz' => Yii::t('main', 'Holati') . ' uz',
            'status_ru' => Yii::t('main', 'Holati') . ' ru',
            'status_en' => Yii::t('main', 'Holati') . ' en'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ListsCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListsLangs()
    {
        return $this->hasMany(ListsLang::className(), ['parent_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ListsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ListsQuery(get_called_class());
    }


}
