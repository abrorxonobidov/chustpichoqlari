<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\models\prices\Prices;
use yii\widgets\MaskedInput;

/**
 * @var $this yii\web\View
 * @var $model common\models\products\Products
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="products-form">

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

    <?= $form->field($model, 'categoriesHelper')
        ->widget(Select2::class,
            [
                'data' => $model->getAllCategories(),
                'options' => [
                    'multiple' => true,
                    'placeholder' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('category')]),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
    ?>

    <div class="row">
        <? $anonsConfig = $model->inputImageConfig('image', Url::to(['/lists/lists/file-remove'])); ?>
        <div class="col-md-6">
            <?= $form->field($model, 'helpImage')
                ->widget(FileInput::class, [
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
            <?= $form->field($model, 'count')->textInput() ?>
            <?= $form->field($model, 'code')->textInput(['disabled' => true]) ?>
            <?= $form->field($model, 'order')->textInput() ?>
            <?= $form->field($model, 'status')->dropDownList(
                $model->getStatusListKeyAndTitle(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('status')]),
                ])
            ?>
        </div>
    </div>

    <? $galleyConfig = $model->inputGalleryConfig(); ?>

    <?= $form->field($model, 'galleryHelper[]')
        ->widget(FileInput::class, [
            'options' => [
                'accept' => 'image/*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'previewFileType' => 'image',
                'allowedFileExtensions' => ['jpg', 'gif', 'png', 'jpeg'],
                'initialPreview' => $galleyConfig['path'],
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => $galleyConfig['config'],
                'showUpload' => false,
                'showRemove' => false,
                'browseClass' => 'btn btn-success',
                'browseLabel' => '<i class="glyphicon glyphicon-folder-open"></i> ' . Yii::t('main', 'Tanlang') . ' ...',
                'browseIcon' => '',
                'overwriteInitial' => false,
            ]
        ]);
    ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'price_amount')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'price_currency_id')
                ->dropDownList(
                Prices::getCurrencyList(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('price_currency_id')]),
                ])
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'price_discount_percent')
                ->textInput()
                //->widget(MaskedInput::class, [
                //    'mask' => '99',
                //])
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'price_discount_fixed')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Saqlash'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
