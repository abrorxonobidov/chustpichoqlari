<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\lists\Lists
 */

$this->title = Yii::t('main', 'Tahrirlash').': ' . $model->titleLang;
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Ro‘yxat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->titleLang, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('main', 'Tahrirlash');
?>
<div class="lists-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
