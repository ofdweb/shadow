<?php

namespace modules\user\backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\user\models\User;
use modules\user\models\UserProfile;
use common\modules\rbac\models\AuthItem;

/**
 * UserSearch represents the model behind the search form of `user\backend\models\User`.
 */
class UserSearch extends User
{
    public $role_list;
    
    public $search;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'created_by'], 'integer'],
            [['search', 'role_list'], 'safe'],
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'role_list' => Yii::t('app', 'Роли')
        ]);
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
        $query = self::find()
          ->joinWith(['profile', 'roles'])
          ->with(['status']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
      
        $dataProvider->sort->attributes['role_list'] = [
            'asc' => [AuthItem::tableName() . '.name' => SORT_ASC],
            'desc' => [AuthItem::tableName() . '.name' => SORT_DESC],
        ];
      
        $dataProvider->sort->attributes['profile.last_vizit_at'] = [
            'asc' => [UserProfile::tableName() . '.last_vizit_at' => SORT_ASC],
            'desc' => [UserProfile::tableName() . '.last_vizit_at' => SORT_DESC],
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

        $query->andFilterWhere(['LIKE', 'username', $this->search])
          ->orFilterWhere(['LIKE', 'email', $this->search]);

        return $dataProvider;
    }
}
