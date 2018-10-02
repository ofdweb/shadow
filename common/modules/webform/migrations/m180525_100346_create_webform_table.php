<?php

use yii\db\Migration;

/**
 * Handles the creation of table `webform`.
 */
class m180525_100346_create_webform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('webform', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64),
            'mailer_component' => $this->string(32)->defaultValue('mailer'),
            'from_email' => $this->string(32),
            'from_name' => $this->string(64),
            'to_email' => $this->string(64),
            'subject' => $this->string(64)->notNull(),
            'body' => $this->text(),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('webform');
    }
}
