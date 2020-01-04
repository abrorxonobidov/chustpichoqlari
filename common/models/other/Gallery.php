<?php

namespace common\models\other;

use Yii;
use common\models\products\Products;
use common\models\base\LocalActiveRecord;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property int $product_id
 * @property string $folder
 * @property int $order
 * @property int $status
 *
 * @property Products $product
 */
class Gallery extends LocalActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    public function afterDelete()
    {
        self::deleteDir($this->folder);
        parent::afterDelete();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'order', 'status'], 'integer'],
            [['folder'], 'string', 'max' => 50],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'product_id' => Yii::t('main', 'Mahsulot') . ' ID',
            'folder' => Yii::t('main', 'Rasm'),
            'order' => Yii::t('main', 'Tartibi'),
            'status' => Yii::t('main', 'Holati'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
    }

    public static function deleteDir($directory)
    {
        $dirPath = Yii::$app->params['galleryUploadPath'] . $directory . '/';
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
