<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file_managed`.
 */
class m180412_082154_create_file_managed_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file_managed', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'storage' => $this->string(32)->notNull(),
            'uri' => $this->string(255)->defaultValue(NULL),
            'size' => $this->bigInteger(20)->unsigned(),
            'mime' => $this->string(32),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer(11)->unsigned(),
            'updated_at' => $this->integer(11)->unsigned(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
      
        $this->createIndex('ind_file_managed_uri', '{{%file_managed}}', 'uri');
        $this->createIndex('ind_file_managed_status_id', '{{%file_managed}}', 'status_id');
      
        $this->addForeignKey('fk_file_managed_created_by', '{{%file_managed}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_file_managed_updated_by', '{{%file_managed}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('file_managed');
    }
}
