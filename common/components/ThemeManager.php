<?php

namespace common\components;

use Yii;

/**
 *
 * @inheritdoc
 */
class ThemeManager extends \yii\base\Theme
{
    public $theme = 'basic';
  
    public function init()
    {
        parent::init();
      
        if ($this->theme) {
            $this->basePath = '@app/themes/' . $this->theme;
            $this->baseUrl = '@web/themes/' . $this->theme;
          
            Yii::setAlias('theme_asset', Yii::$app->assetManager->getPublishedUrl($this->basePath . '/web'));
            Yii::setAlias('theme', $this->basePath . '/views');

            $this->pathMap = [
                '@app/views' => [
                    '@app/themes/' . $this->theme . '/views',
                    //'@app/themes/basic/views',
                ],
               /*'@common/modules' => [
                    '@app/themes/' . $this->theme . '/modules',
                    '@app/themes/basic/modules',
                ],*/
                '@app/widgets/views' => [
                    '@app/themes/' . $this->theme . '/widgets',
                    //'@app/themes/basic/widgets',
                ]
            ];
          
            foreach (Yii::$app->modules as $module) {
                if (is_object($module)) {
                  $this->pathMap['@common/modules/' . $module->id .'/' . Yii::$app->id] = '@app/themes/' . $this->theme . '/modules/' . $module->id;
                }
            }
        }
    }
}