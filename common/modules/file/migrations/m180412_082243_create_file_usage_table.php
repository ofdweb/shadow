<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file_usage`.
 */
class m180412_082243_create_file_usage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file_usage', [
            'fid' => $this->integer(11)->unsigned()->defaultValue(null),
            'entity' => $this->string(32)->notNull(),
            'type' => $this->string(32)->notNull(),
            'entity_id' => $this->integer(11)->unsigned()->defaultValue(null),
            //'PRIMARY KEY(fid, entity, type, entity_id)',
        ]);
      
        $this->createIndex('ind_file_usage_fid', '{{%file_usage}}', 'fid');
        $this->createIndex('ind_file_usage_entity', '{{%file_usage}}', 'entity');
        $this->createIndex('ind_file_usage_type', '{{%file_usage}}', 'type');
        $this->createIndex('ind_file_usage_entity_id', '{{%file_usage}}', 'entity_id');
      
        $this->addForeignKey('fk_file_usage_fid', '{{%file_usage}}', 'fid', '{{%file_managed}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('file_usage');
    }
}
