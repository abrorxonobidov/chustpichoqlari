<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\orders\Orders;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;

/**
 * @var $this yii\web\View
 * @var $model common\models\orders\Orders
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Buyurtmalar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="orders-view">

    <p>
        <?= Html::a(Yii::t('main', 'Tahrirlash'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= $model->status == Orders::STATUS_CANCELLED ? '' : Html::a(Yii::t('main', 'Bekor qilish'), ['cancel-order', 'id' => $model->id, 'return' => "/orders/orders/view?id=$model->id"], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('main', 'Bekor qilishni istaysizmi?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => $model->getAttributeLabel('user_id'),
                //'attribute' => 'user.nameAndSurname',
                'value' => $model->user->getNameAndSurname() . ' (user_id = ' . $model->user_id . ')',

            ],
            'amount',
            'phone',
            [
                'label' => Yii::t('main', 'Mahsulot nomi'),
                'value' =>
                        GridView::widget([
                            'dataProvider' => new ArrayDataProvider([
                                'allModels' => $model->getOrderProducts(),
                                'pagination' => [
                                    'pageSize' => 0,
                                ],
                            ]),
                            'summary' => false,
                            'columns' => [
                                'id',
                                [
                                    'label' => Yii::t('main', 'Nomi'),
                                    'value' => function ($array) {
                                        return
                                            Html::a(
                                                $array['title'],
                                                Url::to(['/products/products/view', 'id' => $array['id']]),
                                                ['target' => '_BLANK']
                                            );
                                    },
                                    'format' => 'html'
                                ],
                                [
                                    'attribute' => 'amount',
                                    'label' => Yii::t('main', 'Narxi'),
                                ],
                                [
                                    'attribute' => 'count',
                                    'label' => Yii::t('main', 'Soni'),
                                ],
                            ],
                        ]),
                'format' => 'raw'
            ],
            [
                'attribute' => 'status',
                'value' => Html::tag('i', '', [
                        'class' => 'fa fa-' . Orders::getOrderStatusList()[$model->status]['icon'],
                        'style' => 'color: ' . Orders::getOrderStatusList()[$model->status]['color'] . '; font-size: 22px;',
                        'title' => Orders::getOrderStatusList()[$model->status]['title']
                    ]) . ' ' . Orders::getOrderStatusList()[$model->status]['title'],
                'format' => 'html'
            ],
        ],
    ]) ?>

</div>
