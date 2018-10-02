<?php
namespace modules\user\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class UserSelect2Widget extends \kartik\select2\Select2
{
    public $urlAdmin = ['/user/util/admin-list-json'];
  
    public $url = ['/user/util/list-json'];
  
    public $admin = false;

     /**
     * {@inheritdoc}
     */
    public function init()
    {      
        $this->data = ($this->model->isNewRecord || !$this->model->created) ? 
          [Yii::$app->user->id => Yii::$app->user->identity->username] : 
          [$this->model->created->id => $this->model->created->username];
      
      
        $this->pluginOptions = array_merge($this->pluginOptions, [
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => Url::to($this->admin ? $this->urlAdmin : $this->url),
                'cache' => true,
                'dataType' => 'json'
            ],
        ]);
      
        parent::init();
    }
}
