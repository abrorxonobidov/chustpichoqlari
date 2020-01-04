<?php

namespace common\models\other;

/**
 * This is the ActiveQuery class for [[PaymentSystems]].
 *
 * @see PaymentSystems
 */
class PaymentSystemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PaymentSystems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PaymentSystems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
