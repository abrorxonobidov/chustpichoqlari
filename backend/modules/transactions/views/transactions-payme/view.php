<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\transactions\TransactionsPayme
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Transactions Paymes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transactions-payme-view">

    <p>
        <?= Html::a(Yii::t('main', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('main', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('main', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order_id',
            'paycom_transaction_id',
            'amount',
            'reason',
            'receivers',
            'paycom_time',
            'paycom_time_datetime',
            'create_time',
            'perform_time',
            'cancel_time',
            'status',
        ],
    ]) ?>

</div>
