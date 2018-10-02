<?php
namespace modules\tag\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class TagSelect2Widget extends \kartik\select2\Select2
{
    public $url = ['/tag/util/list-json'];
  
    public $relation = 'tags';

     /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->options = array_merge($this->options, [
          'placeholder' => Yii::t('app', 'Выберите один или несколько тегов...'),
          'multiple' => true
        ]);
      
        $this->data = $this->model->{$this->relation} ? ArrayHelper::map($this->model->{$this->relation}, 'id', 'title') : [];
      
        $this->pluginOptions = array_merge($this->pluginOptions, [
          'allowClear' => true,
          'tags' => true,
          'ajax' => [
            'url' => Url::to($this->url),
            'cache' => true,
          ],
        ]);
      
        parent::init();
    }
}
