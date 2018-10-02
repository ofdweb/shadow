<?php

class App
{
    public static $pageId = 8;
    
    public static function t($message, $params = [])
    {

        $placeholders = [];
        foreach ((array) $params as $name => $value) {
            $placeholders['{' . $name . '}'] = $value;
        }

        return ($placeholders === []) ? $message : strtr($message, $placeholders);
    }
    
    public static function isFront()
    {
        return implode(DIRECTORY_SEPARATOR, [
          Yii::$app->controller->module->id,
          Yii::$app->controller->id,
          Yii::$app->controller->action->id
        ]) == Yii::$app->defaultRoute;
    }
}