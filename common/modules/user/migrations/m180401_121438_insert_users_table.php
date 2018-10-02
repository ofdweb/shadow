<?php

use yii\db\Migration;
use modules\user\models\SignupForm;
use modules\user\models\User;
/**
 * Class m180401_121438_insert_users_table
 */
class m180401_121438_insert_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new SignupForm();
      
        $user->load([
          'username' => 'admin-ilyha',
          'email' => 'ilyha_roza@mail.ru',
          'password' => '1234567aA',
          'created_by' => 1,
          'updated_by' => 1
        ]);
        
        $user = $user->save();

        if (!$user) {
            var_dump('Unknow error');
        } elseif ($user->hasErrors()) {
            var_dump($user->getErrors());
        } else {
            $user->assignRole('admin');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach (User::find()->All() as $el) {
            $el->delete();
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180401_121438_insert_users_table cannot be reverted.\n";

        return false;
    }
    */
}
