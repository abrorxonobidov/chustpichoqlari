<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\transactions\TransactionsClick;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\transactions\TransactionsClickSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Click to‘lovlar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transactions-click-index">

    <p>
        <?= Html::a(Yii::t('main', 'Create Transactions Click'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            'id',
            [
                'attribute' => 'order_id',
                'value' => function (TransactionsClick $model) {
                    return
                        Html::a('ID: ' . $model->order_id .  ". \t" . $model->order->user->getNameAndSurname() . ". \t". $model->order->phone,
                            Url::to(['/orders/orders/view', 'id' => $model->order_id])
                        );
                },
                'format' => 'html'
            ],
            'click_trans_id',
            'click_paydoc_id',
            'service_id',
            'amount',
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
