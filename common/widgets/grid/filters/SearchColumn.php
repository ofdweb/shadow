<?php

namespace common\widgets\grid\filters;

use Yii;
use yii\helpers\Html;
use yii\grid\Column;
use yii\base\Model;

class SearchColumn extends Column
{
    public $filterInputOptions = [];
    
    public $filter;
    
    public $attribute = 'search';
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->filterInputOptions = array_merge(['placeholder' => $this->placeholderText], $this->filterInputOptions);
    }
  
    public function getPlaceholderText()
    {
        return Yii::t('app', 'Поиск');
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
        if (is_string($this->filter)) {
            return $this->filter;
        }
        $model = $this->grid->filterModel;
        if ($this->filter !== false && $model instanceof Model && $this->attribute !== null && $model->isAttributeActive($this->attribute)) {
            $input = Html::activeTextInput($model, $this->attribute, $this->filterInputOptions);
            $btn = Html::tag('div', Html::button(Html::fa('search'), ['class' => 'btn btn-sm btn-default']), ['class' => 'input-group-btn']);
            return Html::tag('div', Html::tag('div', $input . $btn , ['class' => 'input-group']), ['class' => 'col-md-3 pull-right']);
        }
        return parent::renderFilterCellContent();
    }
}