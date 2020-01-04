<?php

namespace common\models\products;

/**
 * This is the ActiveQuery class for [[ProductCategoryLink]].
 *
 * @see ProductCategoryLink
 */
class ProductCategoryLinkQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductCategoryLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductCategoryLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
