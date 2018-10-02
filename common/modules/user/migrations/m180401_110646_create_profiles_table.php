<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m180401_110646_create_profiles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->integer(11)->notNull(),
            'firstname' => $this->string(32),
            'surname' => $this->string(32),
            'lastname' => $this->string(32),
            'note' => $this->text(),
            'last_vizit_at' => $this->integer()->unsigned(),
            'PRIMARY KEY (user_id)'
        ]);
        
        $this->createIndex('ind_profiles_id', '{{%user_profile}}', 'user_id');
        $this->addForeignKey('fk_user_profile', '{{%user}}', 'id', '{{%user_profile}}', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_profile');
    }
}
