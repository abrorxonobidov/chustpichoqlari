<?php

namespace common\models\prices;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\prices\Prices;

/**
 * PricesSearch represents the model behind the search form of `common\models\prices\Prices`.
 */
class PricesSearch extends Prices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'amount', 'discount_percent', 'discount_fixed', 'status', 'currency_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Prices::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'discount_percent' => $this->discount_percent,
            'discount_fixed' => $this->discount_fixed,
            'status' => $this->status,
            'currency_id' => $this->currency_id,
        ]);

        return $dataProvider;
    }
}
