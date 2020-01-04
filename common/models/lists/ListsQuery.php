<?php

namespace common\models\lists;

/**
 * This is the ActiveQuery class for [[Lists]].
 *
 * @see Lists
 */
class ListsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lists[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lists|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
