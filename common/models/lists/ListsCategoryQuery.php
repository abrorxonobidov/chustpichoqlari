<?php

namespace common\models\lists;

/**
 * This is the ActiveQuery class for [[ListsCategory]].
 *
 * @see ListsCategory
 */
class ListsCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ListsCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ListsCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
