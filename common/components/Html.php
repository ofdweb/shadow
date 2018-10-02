<?php

namespace yii\helpers;

class Html extends BaseHtml
{
    public static function loader($icon = null, $options = [])
    {
        $icon = $icon ?: 'spinner';
        self::addCssClass($options, 'fa-spin h3 loader');
        return self::fa($icon, $options);
    }
  
    public static function tel($value, $options = [])
    {
        $options['href'] = 'tel:' . (isset ($options['phone']) ? $options['phone'] : $value);
        return static::tag('a', $value, $options);
      
        unset($options['phone']);
        return self::a($value, ('tel:' . $phone), $options);
    }
  
    public static function icon($icon, $options = [])
    {
        $icon = 'icon-' . $icon;
        $options['class'] = isset ($options['class']) ? ($options['class'] .' ' . $icon) : $icon;
        return self::tag('i', null, $options);
    }
  
    public static function fa($icon, $options = [])
    {
        $icon = 'fa fa-' . $icon;
        $options['class'] = isset ($options['class']) ? ($options['class'] .' ' . $icon) : $icon;
        return self::tag('i', null, $options);
    }
  
    public static function glyph($icon, $options = [])
    {
        $icon = 'glyphicon glyphicon-' . $icon;
        $options['class'] = isset ($options['class']) ? ($options['class'] .' ' . $icon) : $icon;
        return self::tag('i', null, $options);
    }
  
    public static function saveButton($content, $options = [])
    {
        $content = static::fa('save') . ' ' . $content;
        return static::submitButton($content, $options);
    }
  
    public static function a($text, $url = null, $options = [])
    {
        return (isset($options['visible']) && !$options['visible']) ? null : parent::a($text, $url, $options);
    }

    public static function itemsGroup($items, $key, $tag = 'span', $separate = '', $options = [])
    {
        $result = [];
        foreach (ArrayHelper::getColumn($items, $key) as $el) {
          $result[] = static::tag($tag, $el, $options);
        }
        return implode($separate, $result);
    }
  
    public static function bLisrGroup($items, $key, $options = [])
    {
        if ($items) {
          return static::ul(ArrayHelper::getColumn($items, $key), ['class' => 'list-group', 'itemOptions' => ['class' => 'list-group-item']]);
        }
    }
}