<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\prices\Prices
 */

$this->title = Yii::t('main', 'Tahrirlash').': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Narxlar'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('main', 'Tahrirlash');
?>
<div class="prices-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
