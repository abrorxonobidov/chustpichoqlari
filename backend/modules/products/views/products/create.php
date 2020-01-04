<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\products\Products
 */

$this->title = Yii::t('main', '{0} hosil qilish', [Yii::t('main', 'Mahsulot')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Mahsulotlar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
