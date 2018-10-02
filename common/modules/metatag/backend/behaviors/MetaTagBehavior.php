<?php

namespace modules\metatag\backend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use modules\metatag\models\Metatag;
use yii\web\Request;

class MetaTagBehavior extends Behavior
{
    public function init()
    {
        parent::init();
      
        if (!Yii::$app->request instanceof Request) {
          $this->detach();
        }
    }
    
    public function events()
    {
      return [
          ActiveRecord::EVENT_INIT => 'initModel',
          ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
          ActiveRecord::EVENT_AFTER_VALIDATE => 'afterValidate',
          ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
          ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
          ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
      ];
    }
  
    public function initModel($event)
    {
        $this->owner->metatag = new Metatag([
          'entity' => $this->owner->formName(),
          'title' => '{title} | {siteName}',
          'description' => '{description}'
        ]);
    }
  
    public function afterFind($event)
    {
        $relations = $event->sender->getRelatedRecords();
        if (isset ($relations['metatag']) && $relations['metatag']) {
          $this->owner->metatag = $relations['metatag'];
        }
    }
  
    public function afterValidate($event)
    {
        $this->owner->metatag->load(Yii::$app->request->post());
        $this->owner->metatag->validate();
      
        if ($this->owner->metatag->hasErrors()) {
            $this->owner->addError('metatag', $this->owner->metatag->getFirstErrors());
        }
    }
    
    public function afterSave($event)
    {
        $this->owner->unlinkAll('metatag', true);
        $this->owner->link('metatag', $this->owner->metatag);
    }
  
    public function afterDelete($event)
    {
        $this->owner->unlinkAll('metatag', true);
    }
  
    public function getMetatag()
    {
        return $this->owner->hasOne(Metatag::className(), ['entity_id' => 'id'])
            ->onCondition([Metatag::tableName() . '.entity' => $this->owner->formName()]);
    }
  
    public function setMetatag($value)
    {
        $this->owner->metatag = $value;
    }
}