<?php

/* https://imperavi.com/ */

namespace common\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;
use common\widgets\assets\RedactorAsset;

class Redactor extends InputWidget
{
    public $plugins = [];

    public $clientOptions = [];
  
    public $urlUploadImg = ['/file/manager/inline-upload'];
  
    public $urlUploadFile = ['/file/manager/inline-upload'];
  
    public $urlListImg = ['/file/manager/image-list'];
  
    public $urlListFile = ['/file/manager/file-list'];
  
    private $_assetBundle;
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
      
        $this->options = array_merge($this->options, $this->defaultOptions);
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, $this->plugins, $this->defaultClientOptions, $this->defaultPlugins);

        $this->_assetBundle = RedactorAsset::register($this->getView());
        $this->_assetBundle->setLang($this->clientOptions['lang']);
                                     
        foreach ($this->clientOptions['plugins'] as $plugin) {
          $this->_assetBundle->setPlugin($plugin);
        }

        $this->registerScript();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textArea($this->name, $this->value, $this->options);
        }
      
        echo Html::tag('div', Html::fa('spinner', ['class' => 'text-success fa-spin']), ['class' => 'h2 text-center redactor-spin']);
    }

    protected function getDefaultOptions()
    {
        return [
          'style' => 'display: none;',
        ];
    }
  
    protected function plugins()
    {
        return ['filemanager', 'imagemanager', 'table', 'fullscreen', 'fontcolor', 'fontsize', 'fontfamily', 'definedlinks', 'alignment', 'specialchars', 'video', 'imagebox'];
    }
  
    protected function getDefaultPlugins()
    {
        return [
          'plugins' => $this->plugins(),
          'definedlinks' => [
              ["name" => Yii::t('app', 'Выбрать'), "url" => false],
              ["name" => Yii::t('app', 'Домашний каталог'), "url" => "/"]
           ],
          'imageBoxAttr' => 'data-fancybox',
          'imageBoxValue' => true,
          'imageManagerJson' => Url::to($this->urlListImg),
          'fileManagerJson' => Url::to($this->urlListFile),
          'imageUpload' => Url::to($this->urlUploadImg),
          'fileUpload' => Url::to($this->urlUploadFile),
          'imageResizable' => true,
          'imagePosition' => true,
          'imageUploadErrorCallback' => new JsExpression("function(json){ alert(json.error); }"),
          'fileUploadErrorCallback' => new JsExpression("function(json){ alert(json.error); }"),
        ];
    }

    protected function getDefaultClientOptions()
    {
        return [
          'lang' => explode('-', Yii::$app->language)[0],
          'buttonsAddBefore' => [
              'before' => 'format',
              'buttons' => ['undo', 'redo']
          ]
        ];
    }
  
    /**
     * Register clients script to View
     */
    protected function registerScript()
    {
        $clientOptions = Json::encode($this->clientOptions);
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').redactor({$clientOptions});");
    }
}