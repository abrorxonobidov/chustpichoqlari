<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use common\models\orders\Orders;


/**
 * @var $this yii\web\View
 * @var $searchModel common\models\orders\OrdersSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Buyurtmalar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <p>
        <?= Html::a(Yii::t('main', '{0} hosil qilish', Html::icon('plus')),
            ['create'],
            ['class' => 'btn btn-success', 'title' => Yii::t('main', '{0} hosil qilish', Yii::t('main', 'Buyurtma'))]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_name_and_surname',
                'value' => 'user.nameAndSurname',
            ],
            [
                'attribute' => 'product_id',
                'label' => Yii::t('main', 'Mahsulot nomi'),
                'value' => function ($model) {
                    /** @var $model \common\models\orders\Orders */
                    return
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
                        ]);
                },
                'format' => 'raw'
            ],
            'amount',
            'phone',
            [
                'attribute' => 'status',
                'value' => function (Orders $model) {
                    return Html::tag('i', '', [
                            'class' => 'fa fa-' . Orders::getOrderStatusList()[$model->status]['icon'],
                            'style' => 'color: ' . Orders::getOrderStatusList()[$model->status]['color'] . '; font-size: 22px;',
                            'title' => Orders::getOrderStatusList()[$model->status]['title']
                        ]) . ' ' . Orders::getOrderStatusList()[$model->status]['title'];
                },
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $searchModel::getOrderStatusListForDropdown(),
                    [
                        'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $searchModel->getAttributeLabel('status')]),
                        'class' => 'form-control openSearchBoxToThisSelect',
                    ]
                )
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {cancel-order}',
                'buttons' => [
                    'cancel-order' => function ($url, Orders $model, $key) {
                        return $model->status == Orders::STATUS_CANCELLED ? '' : Html::a(
                            Html::icon('remove', ['class' => 'text-danger']),
                            $url,
                            [
                                'title' => Yii::t('main', 'Bekor qilish'),
                                'data' => [
                                    'confirm' => Yii::t('main', 'Bekor qilishni istaysizmi?'),
                                    'method' => 'post',
                                ],
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>


</div>
