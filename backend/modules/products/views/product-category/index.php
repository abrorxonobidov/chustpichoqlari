<?php

use yii\bootstrap\Html;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\products\ProductCategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Mahsulot kategoriyalari');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-categories-index">

    <p>
        <?= Html::a(Yii::t('main', Html::icon('plus') . ' hosil qilish'), ['create'], ['class' => 'btn btn-success', 'title' => 'Mahsulot kategoriyasi hosil qilish']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'order',
            [
                'attribute' => 'title',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'col-md-4'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\products\ProductCategory */
                    return
                        Html::tag('b', 'uz: ') . $model->title_uz . '<br>' .
                        Html::tag('b', 'ru: ') . $model->title_ru . '<br>' .
                        Html::tag('b', 'en: ') . $model->title_en;
                }
            ],
            [
                'label' => Yii::t('main', 'Rasm'),
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'col-md-3'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\products\ProductCategory */
                    $html = $model->image ? Html::img($model::imageSourcePath() . $model->image, ['class' => 'img-responsive']) : null;
                    return $html;
                }
            ],
            [
                'attribute' => 'status',
                'value' => 'statusIconAndTitle',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'col-md-2'
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
