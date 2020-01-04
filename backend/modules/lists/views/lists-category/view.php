<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\lists\ListsCategory */

$this->title = $model->title_uz;
$this->params['breadcrumbs'][] = ['label' => 'Ro‘yxat kategoriyalari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="lists-category-view">

    <p>
        <?= Html::a('Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O‘chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'O‘chirishni istaysizmi?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'order',
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' =>
                    Html::tag('b', 'uz: ') . $model->title_uz . '<br>' .
                    Html::tag('b', 'ru: ') . $model->title_ru . '<br>' .
                    Html::tag('b', 'en: ') . $model->title_en
            ],
            [
                'attribute' => 'description',
                'format' => 'html',
                'value' =>
                    Html::tag('b', 'uz: ') . $model->description_uz . '<br>' .
                    Html::tag('b', 'ru: ') . $model->description_ru . '<br>' .
                    Html::tag('b', 'en: ') . $model->description_en
            ],
            [
                'attribute' => 'created.date',
                'label' => 'Yaratilgan sana',
            ],
            [
                'attribute' => 'created.user.nameAndSurname',
                'label' => 'Yaratuvchi',
            ],
            [
                'attribute' => 'updated.date',
                'label' => 'Tahrirlangan sana',
            ],
            [
                'attribute' => 'updated.user.nameAndSurname',
                'label' => 'Tahrirlovchi',
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatusIconAndTitle(),
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
