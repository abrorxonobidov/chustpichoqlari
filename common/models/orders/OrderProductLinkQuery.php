<?php

namespace common\models\orders;

/**
 * This is the ActiveQuery class for [[OrderProductLink]].
 *
 * @see OrderProductLink
 */
class OrderProductLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OrderProductLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrderProductLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
