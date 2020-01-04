<?php

namespace common\models\transactions;

/**
 * This is the ActiveQuery class for [[TransactionsPayme]].
 *
 * @see TransactionsPayme
 */
class TransactionsPaymeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TransactionsPayme[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TransactionsPayme|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
