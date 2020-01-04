<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27-Oct-19
 * Time: 17:20
 */

use yii\helpers\Html;

?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="/uploads/user-profile-photos/<?=$user->id?>-main.jpg" class="user-image" alt="User Image"/>
    <span class="hidden-xs"><?=$user->getNameAndSurname()?></span>
</a>
<ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
        <img src="/uploads/user-profile-photos/<?=$user->id?>-main.jpg" class="img-circle"
             alt="User Image"/>

        <p>
            <?=$user->getNameAndSurname()?> - <?=$user->getRole()?>
            <small><?=date("d.m.Y", $user->created_at)?> - dan buyon a'zolikda</small>
        </p>
    </li>
    <!-- Menu Body -->
    <li class="user-body">
        <div class="col-xs-4 text-center">
            <a href="#">Followers</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="#">Sales</a>
        </div>
        <div class="col-xs-4 text-center">
            <a href="#">Friends</a>
        </div>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
        <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
        </div>
        <div class="pull-right">
            <?= Html::a(
                'Sign out',
                ['/site/logout'],
                ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
            ) ?>
        </div>
    </li>
</ul>
