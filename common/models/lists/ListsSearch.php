<?php

namespace common\models\lists;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ListsSearch represents the model behind the search form of `common\models\lists\Lists`.
 *
 * @property $title
 * @property $preview
 * @property $description
 */
class ListsSearch extends Lists
{

    public $title;
    public $preview;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'order', 'status'], 'integer'],
            [['date', 'preview_image', 'description_image'], 'safe'],
            [['title', 'preview', 'description'], 'string'],
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
    public function searchLang($params)
    {

        $query = Lists::find()->select([
            't.*',

            'lang_uz' => 'uz.lang',
            'lang_ru' => 'ru.lang',
            'lang_en' => 'en.lang',

            'title_uz' => 'uz.title',
            'title_ru' => 'ru.title',
            'title_en' => 'en.title',

            'preview_uz' => 'uz.preview',
            'preview_ru' => 'ru.preview',
            'preview_en' => 'en.preview',

            'description_uz' => 'uz.description',
            'description_ru' => 'ru.description',
            'description_en' => 'en.description',

            'status_uz' => 'uz.status',
            'status_ru' => 'ru.status',
            'status_en' => 'en.status',
        ])
            ->from(['t' => Lists::tableName()])
            ->leftJoin(['uz' => ListsLang::tableName()], 'uz.parent_id = t.id and uz.lang = "uz"')
            ->leftJoin(['ru' => ListsLang::tableName()], 'ru.parent_id = t.id and ru.lang = "ru"')
            ->leftJoin(['en' => ListsLang::tableName()], 'en.parent_id = t.id and en.lang = "en"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
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
            't.id' => $this->id,
            't.category_id' => $this->category_id,
            't.order' => $this->order,
            't.status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['like', 't.preview_image', $this->preview_image])
            ->andFilterWhere(['like', 't.description_image', $this->description_image])
            ->andFilterWhere(['like', 't.date', $this->date])
            ->andFilterWhere([
                'or',
                ['like', 'uz.title', $this->title],
                ['like', 'ru.title', $this->title],
                ['like', 'en.title', $this->title]
            ])
            ->andFilterWhere([
                'or',
                ['like', 'uz.preview', $this->preview],
                ['like', 'ru.preview', $this->preview],
                ['like', 'en.preview', $this->preview]
            ])
            ->andFilterWhere([
                'or',
                ['like', 'uz.description', $this->description],
                ['like', 'ru.description', $this->description],
                ['like', 'en.description', $this->description]
            ]);

        return $dataProvider;
    }
}
