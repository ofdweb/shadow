<?php

namespace common\widgets\detail;

use yii\i18n\Formatter;
use yii\helpers\Html;

class DetailFormatter extends Formatter
{
    public function asStatus($value, $params = [])
    {
        if (!$value) {
            return $this->nullDisplay;
        }
      
        $model = \common\models\Status::findOne($value);
      
        return $model ? Html::label($model->name, null, ['class' => 'badge bg-' . $model->bg_color]) : $this->nullDisplay;
    }
  
    public function asImageList($value, $options = [])
    {
        if (!$value) {
            return $this->nullDisplay;
        }
      
        if (is_string($value)) {
            return $this->asImage($value, ['class' => 'img-thumbnail']);
        }
      
        $images = is_array($value) ? $value : [$value];
        $result = [];
      
        foreach ($images as $img) {
            $result[] = $this->asImage($img->thumb, ['class' => 'img-thumbnail']);
        }

        return implode('', $result);
    }
}