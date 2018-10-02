<?php

use yii\db\Migration;
use modules\webform\models\Webform;
use modules\user\models\User;

/**
 * Class m180525_103640_inser_webform_data_table
 */
class m180525_103640_inser_webform_data_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = User::find()->one();
      
        $model = new Webform([
          'title' => 'Контакты',
          'subject' => Yii::t('app', 'Тема письма'),
          'status_id' => 0,
          'created_at' => Yii::$app->formatter->asTimestamp('NOW'),
          'updated_at' => Yii::$app->formatter->asTimestamp('NOW'),
          'created_by' => $user->id,
          'updated_by' => $user->id,
        ]);
      
        $model->detachBehaviors();
        $model->save();
      
        $model = new Webform([
          'title' => 'Обрантый звонок',
          'subject' => Yii::t('app', 'Тема письма'),
          'status_id' => 0,
          'created_at' => Yii::$app->formatter->asTimestamp('NOW'),
          'updated_at' => Yii::$app->formatter->asTimestamp('NOW'),
          'created_by' => $user->id,
          'updated_by' => $user->id,
        ]);
      
        $model->detachBehaviors();
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Webform::deleteAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180525_103640_inser_webform_data_table cannot be reverted.\n";

        return false;
    }
    */
}
