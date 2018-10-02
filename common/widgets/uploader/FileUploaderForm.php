<?php

namespace common\widgets\uploader;

use yii\web\JsExpression;
use common\widgets\FileUploader;

class FileUploaderForm extends FileUploader
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->theme = 'thumbnails';
        $this->limit = 1;
        $this->sort = false;

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
              var plusInput = listEl.find('.fileuploader-thumbnails-input'),
              api = $.fileuploader.getInstance(inputEl.get(0));

              if(api.getFiles().length >= api.getOptions().limit) {
                plusInput.hide();
              }

              plusInput.insertAfter(item.html);

              if(item.format == 'image') {
                item.html.find('.fileuploader-item-icon').hide();
              }
           }"),
          'onItemRemove' => new JsExpression("function(html, listEl, parentEl, newInputEl, inputEl) {
              var plusInput = listEl.find('.fileuploader-thumbnails-input'),
              api = $.fileuploader.getInstance(inputEl.get(0));

              html.children().animate({'opacity': 0}, 200, function() {
                setTimeout(function() {
                  html.remove();

                  if(api.getFiles().length - 1 < api.getOptions().limit) {
                    plusInput.show();
                  }
                }, 100);
              });
            }")
        ]);
    }
}