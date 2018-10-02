<?php
namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class NodeDepDropWidget extends \kartik\depdrop\DepDrop
{
    public $url = ['/core/util/node-list-json'];
  
    public $entityAttribute = 'entity';
  
    public $entityItems = [];

     /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->pluginOptions = array_merge($this->pluginOptions, [
          'depends' => [Html::getInputId($this->model, $this->entityAttribute)],
          'placeholder' => '- ' . Yii::t('app', 'Выбрать') . ' -',
          'url' => Url::to($this->url),
          'initialize' => true,
          'loadingText' => Yii::t('app', 'Загрузка') . '...',
        ]);
      
        $this->options = array_merge($this->options, [
          'placeholder' => '- ' . Yii::t('app', 'Выбрать') . ' -',
        ]);
      
        $this->data = [$this->model->{$this->attribute} => null];
      
        parent::init();
    }
  
     /**
     * {@inheritdoc}
     */
    public function registerAssets()
    {
        echo Html::beginTag('div', ['class' => 'row']);
          echo Html::beginTag('div', ['class' => 'col-md-4']);
            echo Html::activeDropDownList($this->model, $this->entityAttribute, $this->entityItems, [
                'prompt' => '- ' . Yii::t('app', 'Выбрать') . ' -',
                'class' => 'form-control'
            ]);
          echo Html::endTag('div');
          echo Html::beginTag('div', ['class' => 'col-md-8']);
            parent::registerAssets();
          echo Html::endTag('div');
        echo Html::endTag('div');
    }
}
