<?php

namespace modules\user\models;

class UserQuery extends \common\db\BaseQuery
{
    protected $systemRoles = ['admin', 'manager'];
      
    public function roleSystem() 
    {
        return $this
          ->leftJoin('auth_assignment', 'auth_assignment.user_id = user.id')
          ->andWhere(['auth_assignment.item_name' => $this->systemRoles]);
    }
}