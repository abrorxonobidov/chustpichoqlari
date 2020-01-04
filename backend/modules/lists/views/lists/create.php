<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\lists\Lists
 */

$this->title = Yii::t('main', '{0} hosil qilish', [Yii::t('main', 'Ro‘yxat')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('main', 'Ro‘yxat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lists-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
