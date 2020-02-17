<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17-Oct-19
 * Time: 00:18
 */

namespace common\models\base;

use common\components\DebugHelper;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * @property integer $id
 * @property string $titleLang
 * @property string $helpImage
 * @property integer $status
 */
class LocalActiveRecord extends ActiveRecord
{

    public $helpImage;

    public function afterSave($insert, $changedAttributes)
    {
        $this->addLog($insert ? Logs::ACTION_INSERT : Logs::ACTION_UPDATE);
        parent::afterSave($insert, $changedAttributes);
    }


    public function afterDelete()
    {
        $this->addLog(Logs::ACTION_DELETE);
        parent::afterDelete();
    }


    public function addLog($action_id)
    {
        $log = new Logs();
        $log->user_id = Yii::$app->user->id;
        $log->action_id = $action_id;
        $log->date = date('Y-m-d H:i:s');
        $log->row_id = $this->id;
        $log->table = $this::tableName();
        if (!$log->save()) {
            DebugHelper::printSingleObject($log->errors, 0);
        };
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('main', 'ID'),
            'statusIconAndTitle' => Yii::t('main', 'Holati'),
            'statusIcon' => Yii::t('main', 'Holati'),
            'category' => Yii::t('main', 'Kategoriya'),
            'category_id' => Yii::t('main', 'Kategoriya') . ' ID',
            'order' => Yii::t('main', 'Tartibi'),
            'title' => Yii::t('main', 'Nomi'),
            'title_uz' => Yii::t('main', 'Nomi') . ' uz',
            'title_ru' => Yii::t('main', 'Nomi') . ' ru',
            'title_en' => Yii::t('main', 'Nomi') . ' en',
            'titleLang' => Yii::t('main', 'Nomi'),
            'description' => Yii::t('main', 'Batafsil'),
            'description_uz' => Yii::t('main', 'Izoh') . ' uz',
            'description_ru' => Yii::t('main', 'Izoh') . ' ru',
            'description_en' => Yii::t('main', 'Izoh') . ' en',
            'status' => Yii::t('main', 'Holati'),
            'image' => Yii::t('main', 'Rasm'),
            'helpImage' => Yii::t('main', 'Rasm'),
            'created.date' => Yii::t('main', 'Yaratilgan sana'),
            'created.user.nameAndSurname' => Yii::t('main', 'Yaratuvchi'),
            'updated.date' => Yii::t('main', 'Tahrirlangan sana'),
            'updated.user.nameAndSurname' => Yii::t('main', 'Tahrirlovchi'),
        ];
    }


    /**
     * @return array
     */
    public static function getLanguages()
    {
        return ['uz', 'ru', 'en'];
    }


    /**
     * @return array
     */
    public static function getLanguageTitles()
    {
        return [
            'uz' => 'O‘zbekcha',
            'ru' => 'Русский',
            'en' => 'English'
        ];
    }


    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            1 => [
                'title' => 'Aktiv',
                'icon' => 'check-circle',
                'color' => '#00ff00'
            ],
            0 => [
                'title' => 'O‘chirilgan',
                'icon' => 'remove',
                'color' => '#ff0000'
            ],
        ];
    }


    /**
     * @return string
     */
    public function getStatusTitle()
    {
        return self::getStatusList()[$this->status]['title'];
    }


    /**
     * @return string
     */
    public function getStatusIcon()
    {
        return
            Html::tag('i', '', [
                'class' => 'fa fa-' . self::getStatusList()[$this->status]['icon'],
                'style' => 'color: ' . self::getStatusList()[$this->status]['color'] . ';',
                'title' => self::getStatusTitle()
            ]);
    }


    /**
     * @return string
     */
    public function getStatusIconAndTitle()
    {
        return self::getStatusIcon() . " " . self::getStatusTitle();
    }


    /**
     * @return array
     */
    public function getStatusListKeyAndTitle()
    {
        $array = [];
        foreach (self::getStatusList() as $key => $item) {
            $array[$key] = $item['title'];
        }
        return $array;
    }


    /**
     * @return ActiveQuery || Logs
     */
    public function getCreated()
    {
        return $this->hasOne(Logs::class, ['row_id' => 'id'])
            ->onCondition(['table' => $this::tableName(), 'action_id' => Logs::ACTION_INSERT]);
    }


    /**
     * @return ActiveQuery || Logs
     */
    public function getUpdated()
    {
        return $this->hasOne(Logs::class, ['row_id' => 'id'])
            ->onCondition(['table' => $this::tableName(), 'action_id' => Logs::ACTION_UPDATE])
            ->orderBy(['date' => SORT_DESC]);
    }


    /**
     * Generates random string for file names
     * @return string
     */
    public static function createGuid()
    {
        $guid = '';
        $uid = uniqid("", true);
        $data = $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $hash = hash('ripemd128', $uid . $guid . md5($data));
        $guid = substr($hash, 0, 8) .
            '-' . substr($hash, 8, 4) .
            '-' . substr($hash, 12, 4) .
            '-' . substr($hash, 16, 4) .
            '-' . substr($hash, 20, 12);
        return $guid;
    }


    /**
     * Uploads given image by post request
     * @param string $fileInput
     * @param string $field
     * @param string $table
     */
    public function uploadImage($fileInput, $field, $table = '')
    {
        $image = UploadedFile::getInstance($this, $fileInput);
        if ($image) {
            if (!$this->isNewRecord) {
                if (!empty($this->$field)) {
                    $oldImage = self::uploadImagePath() . $this->$field;
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            }

            $imageName = self::createGuid() . '_' . $table . '.' . $image->getExtension();
            $this->$field = $imageName;
            $imagePath = self::uploadImagePath() . $imageName;

            $image->saveAs($imagePath);
            /*if(file_exists($imagePath)){
                list($width, $height) = getimagesize($imagePath);
                if(($width > $imageWidth && $height > $imageHeigth) || ($height > $imageWidth && $width > $imageHeigth)){
                    $resize = new ResizeImage($imagePath);
                    $resize->resizeTo($imageWidth, $imageWidth);
                    unlink($imagePath);
                    $resize->saveImage($imagePath,80);
                }
            }*/
        }
    }


    /**
     * Returns File Upload Configuration for Kartik FileInput widget.
     * @param string $field
     * @param string $deleteUrl
     * @param string $className
     * @return array
     */
    public function inputImageConfig($field, $deleteUrl, $className = LocalActiveRecord::class)
    {
        $config = [
            'path' => [],
            'config' => []
        ];
        if (!$this->isNewRecord && !empty($this->$field)) {
            $image = $this->$field;
            $file = self::uploadImagePath() . $image;
            if (file_exists($file)) {
                $config = [
                    'path' => [
                        Url::to(self::imageSourcePath() . $this->$field)
                    ],
                    'config' => [
                        [
                            'caption' => $image,
                            'size' => filesize($file),
                            'url' => $deleteUrl,
                            'key' => $this->$field,
                            'extra' => [
                                'id' => $this->id,
                                'field' => $field,
                                'className' => $className
                            ],
                        ]
                    ]
                ];
            }
        }
        return $config;
    }


    /**
     * Returns the path that images will be uploaded
     * @return string
     */
    public static function uploadImagePath()
    {
        return Yii::getAlias('@frontend') . '/web/uploads/';
    }


    /**
     * Returns the path that images will be uploaded
     * @return string
     */
    public static function imageSourcePath()
    {
        return 'http://' . str_replace('admin.', '', $_SERVER['SERVER_NAME']) . '/uploads/';
    }

    /**
     * Returns title in current language
     * @return string
     */
    public function getTitleLang(){
        return $this->{'title_'.Yii::$app->language};
    }

}