<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\BootstrapInterface;

class ModuleManager extends Component implements BootstrapInterface
{
  public $modules = [];
  
  public function bootstrap($app)
  {
      $bootstrapMethod = 'bootstrap' . ucfirst(Yii::$app->id);
    
      foreach ($this->modules as $name) {
        switch (Yii::$app->id) {
            case 'frontend':
              $options = [
                'controllerNamespace' => 'common\\modules\\' . $name . '\\frontend\\controllers',
                'viewPath' => '@common/modules/' . $name . '/frontend/views'
              ];
            
            break;
            
            case 'backend':
              $options = [
                'controllerNamespace' => 'common\\modules\\' . $name . '\\backend\\controllers',
                'viewPath' => '@common/modules/' . $name . '/backend/views'
              ];
            break;
            
            case 'console':
              $options = [
                'controllerNamespace' => 'common\\modules\\' . $name . '\\commands',
                'viewPath' => '@app/views'
              ];
            break;
        }

        $options['class'] = 'common\\modules\\' . $name . '\\Module';
        
        Yii::$app->setModule($name, $options);
        
        //Yii::setAlias('@' . $name, $alias);

        $module = Yii::$app->getModule($name);
      
        if ($module->hasMethod('bootstrap')) {
            $module->bootstrap(Yii::$app);
        }
        
        if ($module->hasMethod($bootstrapMethod)) {
            $module->{$bootstrapMethod}(Yii::$app);
        }
      }
    }
}