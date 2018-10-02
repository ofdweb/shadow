<?php

namespace common\modules\setting\components;

use Yii;

/**
 *
 * @inheritdoc
 */
class SettingHelper extends \yii\base\BaseObject
{
    public static function sloganText()
    {
      $text = Yii::t('app', Yii::$app->settings->get('system', 'app_slogan'));
      return preg_replace('/(\s)/', '<br/>', $text, 1);
    }
}