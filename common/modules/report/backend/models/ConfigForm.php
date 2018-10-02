<?php

namespace modules\report\backend\models;

use Yii;
use yii\base\Model;

class ConfigForm extends Model
{
    public $php_version;

    public $web_server;
  
    public $db_name;
    
    public $db_version;
  
    public $memory_limit;
  
    public $yii_version;
  
    public $post_max_size;
  
    public $upload_max_filesize;
  
    public $default_charset;

    /**
     * @inheritdoc
    */ 
    public function rules()
    {
        return [
            [['php_version', 'web_server', 'db_name', 'db_version', 'memory_limit', 'yii_version', 'post_max_size', 'upload_max_filesize'], 'safe'],
            [['default_charset'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'php_version' => Yii::t('app', 'PHP'),
            'web_server' => Yii::t('app', 'Веб-сервер'),
            'db_name' => Yii::t('app', 'СУБД'),
            'db_version' => Yii::t('app', 'Версия СУБД'),
            'memory_limit' => Yii::t('app', 'Ограничение памяти PHP'),
            'yii_version' => Yii::t('app', 'Yii2'),
            'post_max_size' => Yii::t('app', 'Максимальный размер данных'),
            'upload_max_filesize' => Yii::t('app', 'Максимальный размер файла'),
            'default_charset' => Yii::t('app', 'Кодировка сервера'),
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setAttributes([
            'php_version' => phpversion(),
            'post_max_size' => ini_get('post_max_size'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'default_charset' => ini_get('default_charset'),
            'web_server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : null,
            'db_name' => Yii::$app->db->pdo->getAttribute(Yii::$app->db->pdo::ATTR_DRIVER_NAME),
            'db_version' => Yii::$app->db->pdo->query('select version()')->fetchColumn(),
            'memory_limit' => ini_get('memory_limit'),
            'yii_version' => Yii::getVersion(),
        ]);
      
        parent::init();
    }
}