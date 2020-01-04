<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\prices\Prices
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="prices-form">

    <? $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'product_id')->textInput(['disabled' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'amount')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'discount_percent')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'discount_fixed')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList(
                $model->getStatusListKeyAndTitle(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('status')]),
                ]
            ) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'currency_id')->dropDownList(
                $model::getCurrencyList(),
                [
                    'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('currency')]),
                ])
            ->label(Yii::t('main', 'Pul birligi'))
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Saqlash'), ['class' => 'btn btn-success']) ?>
    </div>

    <? ActiveForm::end(); ?>

</div>
