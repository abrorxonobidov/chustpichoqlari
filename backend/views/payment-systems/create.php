<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\other\PaymentSystems */

$this->title = 'Create Payment Systems';
$this->params['breadcrumbs'][] = ['label' => 'Payment Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-systems-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
