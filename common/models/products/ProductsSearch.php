<?php

namespace common\models\products;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property $title
 * @property $description
 * @property $category_id
 * ProductsSearch represents the model behind the search form of `common\models\products\Products`.
 */
class ProductsSearch extends Products
{

    public $title;
    public $description;
    public $category_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'count', 'order', 'status', 'category_id'], 'integer'],
            [['code', 'image', 'title', 'title_uz', 'title_ru', 'title_en', 'description', 'description_uz', 'description_ru', 'description_en'], 'safe'],
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
        $query = Products::find();



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
            'count' => $this->count,
            'order' => $this->order,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'title_uz', $this->title_uz])
            ->andFilterWhere(['like', 'title_ru', $this->title_ru])
            ->andFilterWhere(['like', 'title_en', $this->title_en])
            ->andFilterWhere(['like', 'description_uz', $this->description_uz])
            ->andFilterWhere(['like', 'description_ru', $this->description_ru])
            ->andFilterWhere(['like', 'description_en', $this->description_en])
            ->andFilterWhere([
                    'or',
                    ['like', 'title_uz', $this->title],
                    ['like', 'title_ru', $this->title],
                    ['like', 'title_en', $this->title]
                ]
            )
            ->andFilterWhere([
                    'or',
                    ['like', 'description_uz', $this->description],
                    ['like', 'description_ru', $this->description],
                    ['like', 'description_en', $this->description]
                ]
            );

        return $dataProvider;
    }


}
