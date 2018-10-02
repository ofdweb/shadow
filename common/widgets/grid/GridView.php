<?php

namespace common\widgets\grid;

use Yii;
use yii\grid\GridView as BaseGridView;
use yii\grid\DataColumn;
use yii\helpers\Html;

class GridView extends BaseGridView
{
    const FILTER_POS_NONE = 'none';
  
    public $filters = [];
  
    public $filterPosition;
  
    public $filterFormOptions = ['class' => 'form-filters row'];
  
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        
        if ($this->filters) {
            $this->filterPosition = $this->filterPosition ?: self::FILTER_POS_NONE;
            $this->initFilters();
            
            if (!isset($this->filterFormOptions['id'])) {
                $this->filterFormOptions['id'] = $this->options['id'] . '-form-filters';
                
                $id = $this->filterFormOptions['id'];
                $this->filterSelector = $this->filterSelector ? ($this->filterSelector . ", #$id input, #$id select") : "#$id input, #$id select";
            }
        }
        
        $this->filterPosition = $this->filterPosition ?: self::FILTER_POS_BODY;
    }
  
    /**
     * {@inheritdoc}
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{form_filter}':
                return $this->renderFormFilter();
            default:
                return parent::renderSection($name);
        }
    }
  
    private function renderFormFilter()
    {
        if ($this->filters) {
            $cells = [];
            foreach ($this->filters as $column) {
                /* @var $column Column */
                $column->filterInputOptions = array_merge($column->filterInputOptions, ['class' => 'form-control input-sm']);
                $cells[] = $column->renderFilterCell();
            }
            return Html::tag('div', implode('', $cells), $this->filterFormOptions);
        }
        return '';
    }
  
    protected function initFilters()
    {
        foreach ($this->filters as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                $column = Yii::createObject(array_merge([
                    'class' => $this->dataColumnClass ?: DataColumn::className(),
                    'grid' => $this,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->filters[$i]);
                continue;
            }
            $this->filters[$i] = $column;
        }
    }
}