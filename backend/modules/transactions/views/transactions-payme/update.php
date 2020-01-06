<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\transactions\TransactionsPayme */

$this->title = Yii::t('main', 'Update Transactions Payme: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Transactions Paymes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('main', 'Update');
?>
<div class="transactions-payme-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
