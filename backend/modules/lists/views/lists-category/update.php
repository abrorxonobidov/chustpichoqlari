<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\lists\ListsCategory
 */

$this->title = 'Tahrirlash: ' . $model->title_uz;
$this->params['breadcrumbs'][] = ['label' => 'Ro‘yxat kategoriyalari', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_uz, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>
<div class="lists-category-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
