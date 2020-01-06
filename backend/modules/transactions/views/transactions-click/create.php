<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\transactions\TransactionsClick */

$this->title = Yii::t('main', 'Create Transactions Click');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Transactions Clicks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-click-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
