<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;
use yii\bootstrap\Tabs;

/**
 * @var $this yii\web\View
 * @var $model common\models\products\ProductCategory
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="product-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?
    $items = [];
    foreach ($model->getLanguages() as $lang) {
        $items[] = [
            'label' => $model->getLanguageTitles()[$lang],
            'content' => "<br>" .
                $form->field($model, "title_$lang")->textInput() .
                $form->field($model, "description_$lang")
                    ->widget(TinyMce::className(), [
                        'options' => [
                            'rows' => 16,
                        ],
                        'language' => 'en_GB',
                        'clientOptions' => [
                            'plugins' => [
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste image",
                                "emoticons hr wordcount"
                            ],
                            'toolbar' => "
                                undo redo | styleselect | bold italic underline strike-through | 
                                alignleft aligncenter alignright alignjustify | 
                                bullist numlist outdent indent | media image | link unlink |
                                emoticons charmap insertdatetime hr | subscript superscript | wordcount code
                                "
                        ]
                    ]),
            'options' => ['id' => $model::tableName() . '-' . $lang],
        ];
    }
    ?>

    <?= Tabs::widget([
        'items' => $items
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <? $anonsConfig = $model->inputImageConfig('image', Url::to(['/lists/lists/file-remove'])); ?>
            <?= $form->field($model, 'helpImage')
                ->widget(FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    'pluginOptions' => [
                        'previewFileType' => 'image',
                        'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                        'initialPreview' => $anonsConfig['path'],
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $anonsConfig['config'],
                        'showUpload' => false,
                        'showRemove' => false,
                        'browseClass' => 'btn btn-success',
                        'browseLabel' => '<i class="glyphicon glyphicon-folder-open"></i> Tanlang...',
                        'browseIcon' => ''
                    ]
                ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'order')->textInput() ?>
            <?= $form->field($model, 'status')->dropDownList(
                $model->getStatusListKeyAndTitle(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('status')]),
                ]);
            ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('main', 'Save'), ['class' => 'btn btn-success pull-right btn-lg']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
