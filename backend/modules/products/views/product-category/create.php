<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\products\ProductCategory
 */

$this->title = Yii::t('main', 'Mahsulot kategoriyasi hosil qilish');
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Mahsulot kategoriyalari'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-categories-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
