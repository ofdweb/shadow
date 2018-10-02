<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m180401_110341_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
      
        $this->addForeignKey('fk_user_created_by', '{{%user}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_user_updated_by', '{{%user}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
