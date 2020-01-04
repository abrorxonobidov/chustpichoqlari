<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use common\models\lists\ListsCategorySearch;
use yii\helpers\ArrayHelper;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\lists\ListsSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Ro‘yxat';
$this->params['breadcrumbs'][] = $this->title;

$categoryFilter = ArrayHelper::map(
    (new ListsCategorySearch())->searchLang([])->getModels(),
    'id',
    'titleLang'
);

?>
<div class="lists-index">

    <p>
        <?= Html::a(Html::icon('plus') . ' ' . Yii::t('main', 'hosil qilish'),
            ['create'],
            ['class' => 'btn btn-success', 'title' => Yii::t('main','Ro‘yxat hosil qilish')]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'order',
            'date',
            [
                'label' => 'Nomi',
                'attribute' => 'category_id',
                'format' => 'html',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    $categoryFilter,
                    [
                        'prompt' => Yii::t('main', '"{attribute}"ni tanlang', ['attribute' => $searchModel->getAttributeLabel('category_id')]),
                        'class' => 'form-control openSearchBoxToThisSelect',
                    ]
                ),
                'value' => function ($model) use ($categoryFilter) {
                    /** @var $model \common\models\lists\Lists */
                    return $categoryFilter[$model->category_id];
                }
            ],
            [
                'attribute' => 'title',
                'format' => 'html',
                'contentOptions' => [
                    'class' => 'col-md-3'
                ],
                'value' => function ($model) {
                    /** @var $model \common\models\lists\Lists */
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
                    /** @var $model \common\models\lists\Lists */
                    $html = $model->preview_image ? '<b>Anons:</b><br>' . Html::img($model::imageSourcePath() . $model->preview_image, ['class' => 'img-responsive']) : null;
                    $html = $model->description_image ? $html . '<b>Batafsil:</b><br>' . Html::img($model::imageSourcePath() . $model->description_image, ['class' => 'img-responsive']) : $html;
                    return $html;
                }
            ],
            //[
            //    'attribute' => 'preview',
            //    'format' => 'html',
            //    'contentOptions' => [
            //        'class' => 'col-md-3'
            //    ],
            //    'value' => function ($model) {
            //        /** @var $model \common\models\lists\Lists */
            //        return
            //            Html::tag('b', 'uz: ') . $model->preview_uz . '<br>' .
            //            Html::tag('b', 'ru: ') . $model->preview_ru . '<br>' .
            //            Html::tag('b', 'en: ') . $model->preview_en;
            //    }
            //],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
