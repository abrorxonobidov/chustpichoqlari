<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\prices\Prices
 */

$this->title = Yii::t('main', '{0} hosil qilish', [Yii::t('main', 'Narx')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Mahsulotlar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product->titleLang, 'url' => ['view', 'id' => $model->product->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prices-create">

    <h2> <small><?=Yii::t('main', 'Mahsulot nomi')?>:</small> <?=$model->product->titleLang?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
