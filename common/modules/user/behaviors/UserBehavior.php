<?php

namespace modules\user\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class UserBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function beforeDelete($event)
    {
        //$user = $event->sender;
        //$user->profile->delete();
        //Yii::$app->authManager->revokeAll($user->id);
    }
    
    public function afterDelete($event)
    {
        $user = $event->sender;
        
        if ($user->profile) {
            $transaction = Yii::$app->db->beginTransaction();
            
            try {
                if ($user->profile->delete()) {
                    Yii::$app->authManager->revokeAll($user->id);
                        
                    $transaction->commit();
                    return;
                }
        
                $transaction->rollBack();
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }    
        }
    }
}