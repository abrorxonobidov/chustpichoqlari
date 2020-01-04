<?php

namespace common\models\prices;

/**
 * This is the ActiveQuery class for [[Prices]].
 *
 * @see Prices
 */
class PricesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Prices[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Prices|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
