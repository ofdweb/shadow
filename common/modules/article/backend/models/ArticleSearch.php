<?php

namespace modules\article\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\article\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `modules\article\models\Article`.
 */
class ArticleSearch extends Article
{
    public $search;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['slug', 'search', 'title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Article::find()->joinWith('translations');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
      
        $dataProvider->sort->attributes['title'] = [
            'asc' => ['title' => SORT_ASC],
            'desc' => ['title' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status_id,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['LIKE', 'article_lang.title', $this->search]);

        return $dataProvider;
    }
}
