<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\lists\ListsCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lists-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'title_uz')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'title_ru')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'title_en')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'description_uz')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'description_ru')->textarea(['rows' => 5]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'description_en')->textarea(['rows' => 5]) ?>
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
                ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
