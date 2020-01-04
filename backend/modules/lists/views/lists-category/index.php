<?php

use yii\bootstrap\Html;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\lists\ListsCategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = Yii::t('main', 'Ro‘yxat kategoriyalari');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="lists-category-index">

    <p>
        <?= Html::a(Html::icon('plus') . ' hosil qilish',
            ['create'],
            ['class' => 'btn btn-success', 'title' => 'Ro‘yxat kategoriyasi hosil qilish']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'contentOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
            [
                'attribute' => 'order',
                'contentOptions' => [
                    'class' => 'col-md-1'
                ],
            ],
            [
                'label' => 'Nomi',
                'attribute' => 'title',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'col-md-3'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\lists\ListsCategory */
                    return
                        Html::tag('b', 'uz: ') . $model->title_uz . '<br>' .
                        Html::tag('b', 'ru: ') . $model->title_ru . '<br>' .
                        Html::tag('b', 'en: ') . $model->title_en;
                }
            ],
            [
                'label' => 'Izoh',
                'attribute' => 'description',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'col-md-5'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\lists\ListsCategory */
                    return
                        Html::tag('b', 'uz: ') . $model->description_uz . '<br>' .
                        Html::tag('b', 'ru: ') . $model->description_ru . '<br>' .
                        Html::tag('b', 'en: ') . $model->description_en;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'col-md-3'
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
                'value' => 'statusIcon'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>