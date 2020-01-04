<?php

namespace common\models\lists;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property string $title
 * @property string $description
 * ListsCategorySearch represents the model behind the search form of `common\models\lists\ListsCategory`.
 */
class ListsCategorySearch extends ListsCategory
{

    public $title;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order', 'status'], 'integer'],
            [['title', 'description'], 'string'],
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

        $query = ListsCategory::find()->select([
            't.*',

            'lang_uz' => 'uz.lang',
            'lang_ru' => 'ru.lang',
            'lang_en' => 'en.lang',

            'title_uz' => 'uz.title',
            'title_ru' => 'ru.title',
            'title_en' => 'en.title',

            'description_uz' => 'uz.description',
            'description_ru' => 'ru.description',
            'description_en' => 'en.description',

            'status_uz' => 'uz.status',
            'status_ru' => 'ru.status',
            'status_en' => 'en.status',
        ])
            ->from(['t' => ListsCategory::tableName()])
            ->leftJoin(['uz' => ListsCategoryLang::tableName()], 'uz.parent_id = t.id and uz.lang = "uz"')
            ->leftJoin(['ru' => ListsCategoryLang::tableName()], 'ru.parent_id = t.id and ru.lang = "ru"')
            ->leftJoin(['en' => ListsCategoryLang::tableName()], 'en.parent_id = t.id and en.lang = "en"');

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
        $query
            ->andFilterWhere([
                't.id' => $this->id,
                't.order' => $this->order,
                't.status' => $this->status,
            ])
            ->andFilterWhere([
                    'or',
                    ['like', 'uz.title', $this->title],
                    ['like', 'ru.title', $this->title],
                    ['like', 'en.title', $this->title]
                ]
            )
            ->andFilterWhere([
                    'or',
                    ['like', 'uz.description', $this->description],
                    ['like', 'ru.description', $this->description],
                    ['like', 'en.description', $this->description]
                ]
            );

        return $dataProvider;
    }

}
