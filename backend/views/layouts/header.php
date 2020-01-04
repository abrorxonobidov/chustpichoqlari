<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $content string
 */

?>

<header class="main-header">

    <?= Html::a(Html::tag('span', 'Ch', ['class' => 'logo-mini']) . Html::tag('span', Yii::$app->name, ['class' => 'logo-lg']),
        Yii::$app->homeUrl,
        ['class' => 'logo']);?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!--Messages messagesView -->
                    <?= \backend\widgets\Messages::widget(['directoryAsset' => $directoryAsset]) ?>
                    <!--End Messages messagesView -->
                </li>
                <li class="dropdown notifications-menu">
                    <!--Notifications notificationsView -->
                    <?= \backend\widgets\Notifications::widget() ?>
                    <!--End Notifications notificationsView -->
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <!--Tasks tasksView-->
                    <?= \backend\widgets\Tasks::widget() ?>
                    <!--End Tasks tasksView-->
                </li>
                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <!--UserAccount userAccountView-->
                    <?= \backend\widgets\UserAccount::widget() ?>
                    <!--End UserAccount userAccountView-->
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
