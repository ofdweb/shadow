<?php

namespace modules\page\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PageSearch represents the model behind the search form of `modules\page\models\Page`.
 */
class PageSearch extends Page
{
    public $search;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_by'], 'integer'],
            [['search'], 'safe'],
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
        $query = Page::find()->joinWith('translations');

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
            'status_id' => $this->status_id,
        ]);

        $query->andFilterWhere(['LIKE', 'page_lang.title', $this->search]);

        return $dataProvider;
    }
}
