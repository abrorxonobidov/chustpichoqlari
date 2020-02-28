<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lists\Lists */

$this->title = $model->titleLang;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Ro‘yxat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="lists-view">

    <p>
        <?= Html::a(Yii::t('main', 'Tahrirlash'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('main', 'O‘chirish'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('main', 'O‘chirishni istaysizmi?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category.lang.title',
                'label' => 'Kategoriyasi'
            ],
            'date',
            'order',
            [
                'attribute' => 'preview_image',
                'format' => 'html',
                'value' => Html::img($model::imageSourcePath() . $model->preview_image, ['class' => 'col-md-4'])
                    .' '. Html::tag('p', $model->preview_image)
            ],
            [
                'attribute' => 'description_image',
                'format' => 'html',
                'value' => Html::img($model::imageSourcePath() . $model->description_image, ['class' => 'col-md-4'])
                    .' '. Html::tag('p', $model->description_image)
            ],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' =>
                    Html::tag('b', 'uz: ') . $model->title_uz . '<br>' .
                    Html::tag('b', 'ru: ') . $model->title_ru . '<br>' .
                    Html::tag('b', 'en: ') . $model->title_en
            ],
            [
                'attribute' => 'preview',
                'format' => 'html',
                'value' =>
                    Html::tag('b', 'uz: ') . $model->preview_uz . '<br>' .
                    Html::tag('b', 'ru: ') . $model->preview_ru . '<br>' .
                    Html::tag('b', 'en: ') . $model->preview_en
            ],
            [
                'attribute' => 'description',
                'format' => 'html',
                'value' =>
                    Html::tag('b', 'uz: ') . $model->description_uz . '<br>' .
                    Html::tag('b', 'ru: ') . $model->description_ru . '<br>' .
                    Html::tag('b', 'en: ') . $model->description_en
            ],
            'created.date',
            'created.user.nameAndSurname',
            'updated.date',
            'updated.user.nameAndSurname',
            'statusIconAndTitle:raw',
        ],
    ]) ?>

</div>
