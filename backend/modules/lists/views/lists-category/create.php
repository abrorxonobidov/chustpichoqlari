<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\lists\ListsCategory
 */

$this->title = 'Ro‘yxat kategoriyasi hosil qilish';
$this->params['breadcrumbs'][] = ['label' => 'Ro‘yxat kategoriyalari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lists-category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
