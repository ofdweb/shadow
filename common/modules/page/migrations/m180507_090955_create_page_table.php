<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m180507_090955_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'published_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
      
        $this->addForeignKey('fk_page_created_by', '{{%page}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_page_updated_by', '{{%page}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page');
    }
}
