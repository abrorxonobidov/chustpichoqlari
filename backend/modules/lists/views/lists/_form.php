<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use common\models\lists\ListsCategorySearch;
use kartik\date\DatePicker;
use dosamigos\tinymce\TinyMce;
use yii\helpers\Url;
use kartik\file\FileInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\lists\Lists
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="lists-form">

    <? $form = ActiveForm::begin(); ?>

    <?
    $items = [];
    foreach ($model->getLanguages() as $lang) {
        $items[] = [
            'label' => $model->getLanguageTitles()[$lang],
            'content' => "<br>" .
                $form->field($model, "title_$lang")->textInput() .
                $form->field($model, "preview_$lang")->textarea(['rows' => 5]) .
                $form->field($model, "description_$lang")
                    ->widget(TinyMce::className(), [
                        'options' => ['rows' => 16],
                        'language' => 'en_GB',
                        'clientOptions' => [
                            //'file_picker_callback' => new JsExpression('jsFunctionToBeCalled'),
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
            <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map(
                    (new ListsCategorySearch())->searchLang(['ListsCategorySearch' => ['status' => 1]])->getModels(),
                    'id',
                    'title_uz'
                ),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('category')]),
                ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'value' => date('Y-m-d'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <? $anonsConfig = $model->inputImageConfig('preview_image', Url::to(['/lists/lists/file-remove'])); ?>
            <?= $form->field($model, 'helpPreviewImage')
                ->widget(FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    //'language' => 'en',
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
            <? $anonsConfig = $model->inputImageConfig('description_image', Url::to(['/lists/lists/file-remove'])); ?>
            <?= $form->field($model, 'helpDescriptionImage')
                ->widget(FileInput::className(), [
                    'options' => ['accept' => 'image/*'],
                    //'language' => 'en',
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'order')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(
                $model->getStatusListKeyAndTitle(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('status')]),
                ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <? ActiveForm::end(); ?>

</div>
