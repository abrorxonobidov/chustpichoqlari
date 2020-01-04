<?php

namespace common\models\lists;

/**
 * This is the ActiveQuery class for [[ListsCategoryLang]].
 *
 * @see ListsCategoryLang
 */
class ListsCategoryLangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ListsCategoryLang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ListsCategoryLang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
