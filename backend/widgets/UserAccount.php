<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27-Oct-19
 * Time: 05:28
 */

namespace backend\widgets;

use yii\base\Widget;
use Yii;

class UserAccount extends Widget
{

    public function run()
    {
        return $this->render('userAccountView', [
            'user' => Yii::$app->user->identity
        ]);
    }
}