<?php

namespace modules\menu\models;

use paulzi\nestedintervals\NestedIntervalsQueryTrait;

class MenuQuery extends \common\db\BaseQuery
{
    use NestedIntervalsQueryTrait;
  
    public function tree($id) 
    {
        return $this->byParams([$this->modelClass::tableName() . '.tree' => $id])->one();
    }
    
    public function mainMenu()
    {
        return $this->andWhere([$this->modelClass::tableName() . '.tree' => $this->modelClass::MAIN_MENU]);
    }
}

