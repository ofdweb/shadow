<?php

namespace common\widgets\uploader;

use yii\web\JsExpression;
use common\widgets\FileUploader;

class FileUploaderThumb extends FileUploader
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->theme = 'thumbnails';
        parent::init();
    }
  
    protected function setEvents()
    {
        parent::setEvents();
      
        $this->clientOptions['afterRender'] = new JsExpression("function(listEl, parentEl, newInputEl, inputEl) {
           var plusInput = listEl.find('.fileuploader-thumbnails-input'),
           api = $.fileuploader.getInstance(inputEl.get(0));

           plusInput.on('click', function() {
            api.open();
          });
        }");
    }
  
    protected function getThumbnails()
    {
        return array_merge(parent::getThumbnails(), [
          'onItemShow' => new JsExpression("function(item, listEl, parentEl, newInputEl, inputEl) {
              var plusInput = listEl.find('.fileuploader-thumbnails-input');
              plusInput.insertAfter(item.html);

              if(item.format == 'image') {
                item.html.find('.fileuploader-item-icon').hide();
              }
           }")
        ]);
    }
}