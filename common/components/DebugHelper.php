<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15-Oct-19
 * Time: 00:37
 */

namespace common\components;


class DebugHelper
{
    public static function printSingleObject($array, $die = true)
    {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        if ($die) die();
    }
}