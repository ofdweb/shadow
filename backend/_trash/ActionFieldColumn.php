<?php

namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\DataColumn;

class ActionFieldColumn extends DataColumn 
{
    public $headerOptions = ['class' => 'action-field-column'];
  
    public $controller;

    public $template = '{view} {update} {delete}';
  
    public $buttons = [];
  
    public $visibleButtons = [];
  
    public $buttonOptions = [];
  
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'Просмотр');
        $this->initDefaultButton('update', 'Изменить');
        $this->initDefaultButton('delete', 'Удалить', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }
  
    protected function initDefaultButton($name, $title, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $title, $additionalOptions) {
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => true,
                ], $additionalOptions, $this->buttonOptions);

                return Html::a(Yii::t('yii', $title), $url, $options);
            };
        }
    }
  
    public function createUrl($action, $model, $key, $index)
    {
        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
      
        return Url::toRoute($params);
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        return parent::renderDataCellContent($model, $key, $index) . Html::tag('div', preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }
            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            }
            return '';
        }, $this->template));
    }
}