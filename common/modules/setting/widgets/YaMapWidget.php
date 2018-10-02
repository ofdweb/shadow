<?php

namespace modules\setting\widgets;

use Yii;

class YaMapWidget extends \mirocow\yandexmaps\Canvas
{
    private $_api;
  
    public $attribute = 'app_yamap';
  
    public function init()
    {
      $coord = explode(',',  Yii::$app->settings->get('system', $this->attribute));
      $placemark = new \mirocow\yandexmaps\objects\Placemark($coord);
        
      $map = new \mirocow\yandexmaps\Map('yandex_map', [
        'center' => $coord,
        'zoom' => 14,
        'type' => "yandex#map",
      ]          
    );  
      
      $this->htmlOptions = [
        'style' => 'height: 400px;',
      ];
      
      $map->addObject($placemark);
      $this->setMap($map);

      parent::init();
    }
  
    /**
     * @return Api
    */
    public function getApi() 
    {
      if (!$this->_api) {
        $this->_api = new \mirocow\yandexmaps\Api();
      }
      
      return $this->_api;
    } 
    
}