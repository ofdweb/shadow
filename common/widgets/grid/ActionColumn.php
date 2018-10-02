<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\Column;

class ActionColumn extends Column
{
    /**
     * {@inheritdoc}
     */
    public $headerOptions = ['class' => 'text-right'];
  
    public $contentOptions = ['class' => 'text-right'];

    public $controller;

    public $template = '{view} {update} {delete}';

    public $buttons = [];

    public $visibleButtons = [];

    public $urlCreator;

    public $buttonOptions = [];
  
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }
  
    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'info', 'eye');
        $this->initDefaultButton('update', 'primary', 'edit');
        $this->initDefaultButton('delete', 'danger', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]);
    }
    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $btnName, $btnIcon, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $btnName, $btnIcon, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('app', 'Просмотр');
                        break;
                    case 'update':
                        $title = Yii::t('app', 'Изменить');
                        break;
                    case 'delete':
                        $title = Yii::t('app', 'Удалить');
                        break;
                    default:
                        $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'class' => ('btn btn-sm btn-' . $btnName),
                    //'data-pjax' => true,
                    //'data-grid-action' => true
                ], $additionalOptions, $this->buttonOptions);
                return Html::a((Html::fa($btnIcon) . ' ' . $title), $url, $options);
            };
        }
    }

    public function createUrl($action, $model, $key, $index)
    {
        if (is_callable($this->urlCreator)) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index, $this);
        }
        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
        return Url::toRoute($params);
    }
  
    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
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
        }, $this->template);
    }
}