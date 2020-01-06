<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\transactions\TransactionsPayme
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="transactions-payme-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->textInput() ?>

    <?= $form->field($model, 'paycom_transaction_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput() ?>

    <?= $form->field($model, 'receivers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paycom_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'paycom_time_datetime')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'perform_time')->textInput() ?>

    <?= $form->field($model, 'cancel_time')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('main', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
