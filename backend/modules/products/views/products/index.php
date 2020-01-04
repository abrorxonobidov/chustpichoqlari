<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\products\ProductsSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Mahsulotlar');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <p>
        <?= Html::a(Html::icon('plus') . ' ' . Yii::t('main', 'hosil qilish'),
            ['create'],
            ['class' => 'btn btn-success', 'title' => Yii::t('main', 'Ro‘yxat hosil qilish')]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'title',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'col-md-3'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\products\Products */
                    return
                        Html::tag('b', 'uz: ') . $model->title_uz . '<br>' .
                        Html::tag('b', 'ru: ') . $model->title_ru . '<br>' .
                        Html::tag('b', 'en: ') . $model->title_en;
                }
            ],
            //'code',
            [
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var $model \common\models\products\Products */
                    return GridView::widget([
                        'dataProvider' => new ArrayDataProvider([
                            'allModels' => $model->categories
                        ]),
                        'showHeader' => false,
                        'tableOptions' => ['class' => 'table table-bordered'],
                        'summary' => false,
                        'columns' => [
                            'id',
                            'title_' . Yii::$app->language,
                        ]
                    ]);
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    $searchModel->getAllCategories(),
                    [
                        'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $searchModel->getAttributeLabel('category')]),
                        'class' => 'form-control openSearchBoxToThisSelect',
                    ]
                ),
            ],
            [
                'label' => Yii::t('main', 'Rasm'),
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'col-md-3'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\products\Products */
                    $html = $model->image ? Html::img($model::imageSourcePath() . $model->image, ['class' => 'img-responsive']) : null;
                    return $html;
                }
            ],
            'count',
            'order',
            [
                'attribute' => 'status',
                'value' => 'statusIconAndTitle',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'col-md-1'
                ],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    $searchModel->getStatusListKeyAndTitle(),
                    [
                        'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $searchModel->getAttributeLabel('status')]),
                        'class' => 'form-control openSearchBoxToThisSelect',
                    ]
                ),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit-price} {view} {update} {delete}',
                'buttons' => [
                    'edit-price' => function ($url, $model, $key) {
                        return Html::a(
                            Html::icon('plus'),
                            $url,
                            [
                                'title' => Yii::t('main', 'Mahsulot narxini tahrirlash')
                            ]
                        );
                    }
                ],

            ],
        ],
    ]); ?>


</div>
