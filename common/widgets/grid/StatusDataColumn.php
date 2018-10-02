<?php

namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\DataColumn;

class StatusDataColumn extends DataColumn 
{
    public $format = 'raw';
  
    public $attribute = 'status_id';
  
    public function getDataCellValue($model, $key, $index)
    {
        return $model->status ? Html::label($model->status->name, null, ['class' => 'badge bg-' . $model->status->bg_color]) : null; 
    }
}