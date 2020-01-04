<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27-Oct-19
 * Time: 05:28
 */

namespace backend\widgets;

use yii\base\Widget;

/**
 * @property  $directoryAsset
 */
class Messages extends Widget
{

    public $directoryAsset;

    public function run()
    {
        return $this->render('messagesView', [
            'messages' => 5,
            'directoryAsset' => $this->directoryAsset
        ]);
    }
}