<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\products\ProductCategory
 */

$this->title = $model->titleLang;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Mahsulot kategoriyalari'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-categories-view">

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
            'order',
            'title_uz',
            'title_ru',
            'title_en',
            'description_uz:html',
            'description_ru:html',
            'description_en:html',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => Html::img($model::imageSourcePath() . $model->image, ['class' => 'col-md-4'])
                    .' '. Html::tag('p', $model->image)
            ],
            'created.date',
            'created.user.nameAndSurname',
            'updated.date',
            'updated.user.nameAndSurname',
            'statusIconAndTitle:raw',
        ],
    ]) ?>

</div>
