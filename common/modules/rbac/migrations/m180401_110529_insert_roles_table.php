<?php

use yii\db\Migration;

/**
 * Class m180401_110529_insert_roles_table
 */
class m180401_110529_insert_roles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $manager = $auth->createRole('manager');
        $manager->description = 'Менеджер';
        $auth->add($manager);

        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $auth->add($admin);
        $auth->addChild($admin, $manager);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->authManager->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180401_110529_insert_roles_table cannot be reverted.\n";

        return false;
    }
    */
}
