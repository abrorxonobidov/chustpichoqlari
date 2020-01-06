<?php

namespace common\models\transactions;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TransactionsPaymeSearch represents the model behind the search form of `common\models\transactions\TransactionsPayme`.
 */
class TransactionsPaymeSearch extends TransactionsPayme
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'amount', 'reason', 'status'], 'integer'],
            [['paycom_transaction_id', 'receivers', 'paycom_time', 'paycom_time_datetime', 'create_time', 'perform_time', 'cancel_time'], 'safe'],
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
        $query = TransactionsPayme::find();

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
            'amount' => $this->amount,
            'reason' => $this->reason,
            'paycom_time_datetime' => $this->paycom_time_datetime,
            'create_time' => $this->create_time,
            'perform_time' => $this->perform_time,
            'cancel_time' => $this->cancel_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'paycom_transaction_id', $this->paycom_transaction_id])
            ->andFilterWhere(['like', 'receivers', $this->receivers])
            ->andFilterWhere(['like', 'paycom_time', $this->paycom_time]);

        return $dataProvider;
    }
}
