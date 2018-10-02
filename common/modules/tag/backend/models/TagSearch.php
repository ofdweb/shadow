<?php

namespace modules\tag\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TagSearch represents the model behind the search form of `user\backend\models\User`.
 */
class TagSearch extends Tag
{
    public $search;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
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
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
      
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['LIKE', 'title', $this->search]);

        return $dataProvider;
    }
}
