<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/**
 * @var $this yii\web\View
 * @var $model common\models\products\Products
 */

$this->title = $model->titleLang;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Mahsulotlar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="products-view">

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
            'code',
            'title_uz',
            'title_ru',
            'title_en',
            'count',
            [
                'label' => Yii::t('main', 'Narxlar'),
                'format' => 'raw',
                'value' => (($price = $model->price) !== null) ? DetailView::widget([
                    'model' => $price,
                    'attributes' => [
                        [
                            'attribute' => 'actualAmount',
                            'format' => 'raw',
                        ],
                        'amount',
                        'currency',
                        'discount_percent',
                        'discount_fixed',
                        'created.date',
                        'created.user.nameAndSurname',
                    ]
                ]) : null,
            ],
            [
                'attribute' => 'categoriesHelper',
                'value' => GridView::widget([
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $model->categories
                    ]),
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'summary' => false,
                    'columns' => [
                        'id',
                        'title_uz',
                        'title_ru',
                        'title_en',
                    ]
                ]),
                'format' => 'raw'
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => Html::img($model::imageSourcePath() . $model->image, ['class' => 'col-md-4'])
                    . ' ' . Html::tag('p', $model->image)
            ],
            [
                'label' => Yii::t('main', 'Galeriya'),
                'format' => 'html',
                'value' => function ($model) {
                    /** @var $model \common\models\products\Products */
                    $images = glob(Yii::$app->params['galleryUploadPath'] . $model->galleryFolder . "/{*.jpg,*.jpeg,*.gif,*.png}", GLOB_BRACE);
                    $gallery = [];
                    foreach ($images as $image) {
                        $filePath = explode('/', $image);
                        $fileName = end($filePath);
                        $gallery[] = Html::img($model::imageSourcePath() . 'gallery/' . $model->galleryFolder . '/' . $fileName, ['style' => 'height:150px;']);
                    }
                    return implode(' ', $gallery) . Html::tag('br') . $model->galleryFolder;
                }
            ],
            'order',
            'description_uz:html',
            'description_ru:html',
            'description_en:html',
            'created.date',
            'created.user.nameAndSurname',
            'updated.date',
            'updated.user.nameAndSurname',
            'statusIconAndTitle:raw',
        ],
    ]) ?>

</div>
