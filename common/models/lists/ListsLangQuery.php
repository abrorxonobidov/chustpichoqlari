<?php

namespace common\models\lists;

/**
 * This is the ActiveQuery class for [[ListsLang]].
 *
 * @see ListsLang
 */
class ListsLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ListsLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ListsLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
