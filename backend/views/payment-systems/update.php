<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\other\PaymentSystems */

$this->title = 'Update Payment Systems: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Payment Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payment-systems-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
