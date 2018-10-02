<?php

namespace modules\webform\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\webform\models\WebformResult;

/**
 * WebformResultSearch represents the model behind the search form of `user\backend\models\User`.
 */
class WebformResultSearch extends WebformResult
{
    public $search;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['form_id'], 'integer'],
            [['search'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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

        return $dataProvider;
    }
}
