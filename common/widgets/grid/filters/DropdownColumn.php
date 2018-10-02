<?php

namespace common\widgets\grid\filters;

use Yii;
use yii\helpers\Html;
use yii\grid\Column;
use yii\base\Model;

class DropdownColumn extends Column
{
    public $filterInputOptions = [];
    
    public $attribute;
  
    public $filter;
  
    public $items;
  
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->filterInputOptions = array_merge(['prompt' => '- ' . $this->promptText . ' -'], $this->filterInputOptions);
    }
  
    public function getPromptText()
    {
        return Yii::t('app', 'Выбрать');
    }
    
    /**
     * {@inheritdoc}
     */
    public function renderFilterCell()
    {
        return $this->renderFilterCellContent();
    }
    
    /**
     * {@inheritdoc}
     */
    protected function renderFilterCellContent()
    {
        $model = $this->grid->filterModel;
      
        if ($this->items && is_array($this->items) && $this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            $input = Html::activeDropDownList($model, $this->attribute, $this->items, $this->filterInputOptions);
            return Html::tag('div', $input, ['class' => 'col-md-2 pull-right']);
        }
      
        return parent::renderFilterCellContent();
    }
}