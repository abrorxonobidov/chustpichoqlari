<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\transactions\TransactionsPayme */

$this->title = Yii::t('main', 'Create Transactions Payme');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Transactions Paymes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-payme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
