<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\orders\Orders
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['disabled' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        $model->getOrderStatusListForDropdown(),
        [
            'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $model->getAttributeLabel('status')]),
            'class' => 'form-control openSearchBoxToThisSelect',
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
