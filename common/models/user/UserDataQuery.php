<?php

namespace common\models\user;

/**
 * This is the ActiveQuery class for [[UserData]].
 *
 * @see UserData
 */
class UserDataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
