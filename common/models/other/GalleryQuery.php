<?php

namespace common\models\other;

/**
 * This is the ActiveQuery class for [[Gallery]].
 *
 * @see Gallery
 */
class GalleryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gallery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gallery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
