<?php

namespace common\models\transactions;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\transactions\TransactionsClick;

/**
 * TransactionsClickSearch represents the model behind the search form of `common\models\transactions\TransactionsClick`.
 */
class TransactionsClickSearch extends TransactionsClick
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'click_trans_id', 'click_paydoc_id', 'service_id', 'amount', 'status'], 'integer'],
            [['perform_time', 'cancel_time'], 'safe'],
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
        $query = TransactionsClick::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
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
            'order_id' => $this->order_id,
            'click_trans_id' => $this->click_trans_id,
            'click_paydoc_id' => $this->click_paydoc_id,
            'service_id' => $this->service_id,
            'amount' => $this->amount,
            'perform_time' => $this->perform_time,
            'cancel_time' => $this->cancel_time,
            'status' => $this->status,
        ]);

        return $dataProvider;
    }
}
