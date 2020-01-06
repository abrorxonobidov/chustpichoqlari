<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\transactions\TransactionsPayme;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\transactions\TransactionsPaymeSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Payme to‘lovlar ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-payme-index">

    <p>
        <?= Html::a(Yii::t('main', 'Create Transactions Payme'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'order_id',
                'value' => function (TransactionsPayme $model) {
                    return
                        Html::a('ID: ' . $model->order_id .  ". \t" . $model->order->user->getNameAndSurname() . ". \t". $model->order->phone,
                            Url::to(['/orders/orders/view', 'id' => $model->order_id])
                        );
                },
                'format' => 'html'
            ],
            'paycom_transaction_id',
            'amount',
            'reason',
            //'receivers',
            //'paycom_time',
            //'paycom_time_datetime',
            //'create_time',
            //'perform_time',
            //'cancel_time',
            [
                'attribute' => 'status',
                'value' => 'statusIconAndTitle',
                'format' => 'html'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
