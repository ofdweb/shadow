<?php

/*
* https://innostudio.de/fileuploader/documentation/#examples
*/

namespace common\widgets;

use Yii;
use yii\widgets\InputWidget;
use common\widgets\assets\FileUploaderAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

abstract class FileUploader extends InputWidget
{
    public $theme;
  
    public $clientOptions = [];
  
    public $clientEvents = [];
  
    public $limit;
  
    public $files;
  
    public $sort = true;
  
    public $extensions;
  
    public $urlUnlink = ['/file/manager/unlink'];
  
    public $urlSort = ['/file/manager/sort'];
  
    private $_class;
  
    private $_entityId;
  
    private $_attribute;
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
      
        $this->options = array_merge ($this->options, [
          'data-fileuploader' => true,
          'multiple' => true
        ]);
      
        $this->urlUnlink = Json::encode(Url::to($this->urlUnlink));
        $this->urlSort = Json::encode(Url::to($this->urlSort));
        $this->_class =  Json::encode($this->model->className());

        $this->_entityId = !$this->model->isNewrecord ? Json::encode($this->model->primaryKey) : 0;
        $this->_attribute = Json::encode(str_replace('[]', '', $this->attribute));

        FileUploaderAsset::register($this->getView())->addTheme($this->theme);
      
        $this->setOptions();
        $this->setEvents();

        $this->registerClientScript();
    }
  
    protected function setOptions()
    {
        $this->clientOptions = array_merge ([
          'class' => null,
          'theme' => $this->theme,
          'enableApi' => true,
          'addMore' => true,
          'limit' => $this->limit,
          'captions' => $this->captions,
          'sorter' => $this->sorter,
          'files' => $this->fileList,
          'thumbnails' => $this->thumbnails,
        ], $this->clientOptions, $this->clientEvents);
    }
  
    protected function setEvents()
    {
        if ($this->hasModel() && !$this->model->isNewRecord) {
            $this->clientOptions['onRemove'] = new JsExpression("function(item, listEl, parentEl, newInputEl, inputEl) {
                if (item.data.fid) {
                  $.ajax({
                    url: $this->urlUnlink,
                    type: 'DELETE',
                    data: {fid: item.data.fid, class: $this->_class, id: $this->_entityId, attribute: $this->_attribute}
                  });
                }  
             }");  
        }
    }
  
    protected function getThumbnails()
    {
        return [
          'item' => $this->render('@common/widgets/views/file-uploader/_' . $this->theme . '-item', ['sort' => $this->sort]),
          'box' => null,
          'item2' => null,
        ];
    }
  
    protected function getSorter()
    {
        return $this->sort ? [
            'selectorExclude' => null,
            'placeholder' => null,
            'scrollContainer' => new JsExpression("window"),
            'onSort' => new JsExpression("function(list, listEl, parentEl, newInputEl, inputEl) {
                 let _list = [];
                 
                 $.each(list, function(i, item) {
                    if (item.data.fid) {
                      _list.push({
                          fid: item.data.fid,
                          weight: item.index
                      });
                    }
                });
                
                if (_list) {
                    $.ajax({
                        url: $this->urlSort,
                        type: 'POST',
                        data: {list: _list, class: $this->_class, id: $this->_entityId, attribute: $this->_attribute}
                     });  
                } 
             }")
        ] : null;
    }
  
    protected function getFileList()
    {
        return $this->files ? ArrayHelper::toArray($this->files, [
            'modules\file\models\FileManaged' => [
              'name',
              'type' => 'mime',
              'size',
              'file' => 'thumb',
              'data' => function ($model) {
                return [
                  'fid' => $model->id
                ];
              }
            ]
          ]) : null;
    }
  
    protected function getCaptions()
    {
        return [
                'button' => Yii::t('app', 'Выберите {limit, plural, =1{файл} other{файлы}}', ['limit' => $this->limit]),
                'confirm' => Yii::t('app', 'Подтвердить'),
                'cancel' => Yii::t('app', 'Отмена'),
                'name' => Yii::t('app', 'Название'),
                'type' => Yii::t('app', 'Тип'),
                'size' => Yii::t('app', 'Размер'),
                'dimensions' => Yii::t('app', 'Расширение'),
                'duration' => Yii::t('app', 'Продолжительность'),
                'crop' => Yii::t('app', 'Обрезать'),
                'rotate' => Yii::t('app', 'Повернуть'),
                'sort' => Yii::t('app', 'Сортировка'),
                'download' => Yii::t('app', 'Скачать'),
                'remove' => Yii::t('app', 'Удалить'),
                'drop' => Yii::t('app', 'Перетащите файлы сюда'),
                'removeConfirmation' => Yii::t('app', 'Вы действиетльно хотите удалить файл?'),
                'feedback' => Yii::t('app', 'Выберите {limit, plural, =1{файл} other{файлы}} для загрузки', ['limit' => $this->limit]),
                'feedback2' => new JsExpression("function(options) {
                    if (options.length > 4) {
                      return options.length + ' ' + '" . Yii::t('app', 'файлов выбрано') . "';
                    } else if (options.length > 1) {
                      return options.length + ' ' + '" . Yii::t('app', 'файла выбрано') . "';
                    }
                    
                    return options.length + ' ' + '" . Yii::t('app', 'файл выбран') . "';
                    return options.length + ' ' + (options.length > 1 ? ' " . Yii::t('app', 'файлов выбрано') . "' : ' " . Yii::t('app', 'файл выбран') . "'); 
                }"),

                'errors' => [
                    'filesLimit' => Yii::t('app', 'Только ${limit} файлов может быть загружено'),
                    'filesType' => Yii::t('app', 'Only ${extensions} files are allowed to be uploaded.'),
                    'fileSize' => Yii::t('app', '${name} is too large! Please choose a file up to ${fileMaxSize}MB.'),
                    'filesSizeAll' => Yii::t('app', 'Files that you choosed are too large! Please upload files up to ${maxSize} MB.'),
                    'fileName' => Yii::t('app', 'File with the name ${name} is already selected.'),
                    'folderUpload' => Yii::t('app', 'You are not allowed to upload folders.') 
                ]
         ];
    }
  
    /**
     * @inheritdoc
     */
    public function run()
    {
        $input = $this->hasModel()
            ? Html::activeFileInput($this->model, $this->attribute, $this->options)
            : Html::fileInput($this->name, $this->value, $this->options);
      
        return $this->render('@common/widgets/views/file_uploader_' . $this->theme, [
          'input' => $input, 
          'caption' => $this->clientOptions['captions'],
          'class' => $this->clientOptions['class'],
        ]);
    }
  
    public function registerClientScript()
    {
        $options = Json::encode($this->clientOptions);
        $id = Json::htmlEncode('#' . $this->options['id']);
      
        $script = <<< JS
          $($id).fileuploader($options); 
JS;
      
        $this->getView()->registerJs($script);
    }
}