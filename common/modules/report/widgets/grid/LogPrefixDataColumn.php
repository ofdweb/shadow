<?php

namespace modules\report\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\DataColumn;
use modules\user\models\User;

class LogPrefixDataColumn extends DataColumn 
{
    public $format = 'raw';
  
    public $attribute = 'prefix';
  
    public $userList;
  
    public function init()
    {
        parent::init();
      
        if (!$this->label) {
          $this->label = Yii::t('app', 'Пользователь');
        }

        if (!$this->userList) {
          $this->userList = User::find()
            ->roleSystem()
            ->withTrashed()
            ->indexBy('id')
            ->all();
        }
    }
  
    public function getDataCellValue($model, $key, $index)
    {
        $pattern = "|\[(.*?)\]|si";
            
        if (preg_match_all($pattern, $model['prefix'], $match)) {
          list($ip, $userId, $session) = $match[1];
          $ip = Html::tag('p', $ip, ['class' => 'small text-muted']);
              
          if (!isset($this->userList[$userId])) {
              return $ip;
          }
              
          $user = $this->userList[$userId];
          return Html::a($user->username, ['/user/default/view', 'id' => $user->id], ['target' => '_blank']) . $ip;
        }

        return null;
    }
}