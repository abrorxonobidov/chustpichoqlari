<?php

namespace common\models\orders;

use common\models\user\UserData;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `common\models\orders\Orders`.
 * @property string $user_name_and_surname
 * @property integer $product_id
 */
class OrdersSearch extends Orders
{

    public $user_name_and_surname;
    public $product_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'amount', 'status', 'product_id'], 'integer'],
            [['phone', 'user_name_and_surname'], 'safe'],
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
        $query = Orders::find()
            ->select([
                'o.*',
                'ud.first_name',
                'ud.last_name',
            ])
            ->from(['o' => Orders::tableName()])
            ->innerJoin(['ud' => UserData::tableName()], 'o.user_id = ud.user_id')
        ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder'=> [
                'id' => SORT_DESC
            ]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'o.id' => $this->id,
            'o.user_id' => $this->user_id,
            'o.amount' => $this->amount,
            'o.status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['like', 'CONCAT(ud.first_name, ud.last_name)', $this->user_name_and_surname])
            ->andFilterWhere(['like', 'o.phone', $this->phone]);

        if ($this->product_id){
            // TODO buni boshqa joylarga ham joriy qilish kerak
            $order_ids = OrderProductLink::find()
                ->select('order_id')
                ->where(['product_id' => $this->product_id])
                ->asArray();
                $query->andFilterWhere(['IN', 'o.id', $order_ids ]);
        };

        return $dataProvider;
    }
}
