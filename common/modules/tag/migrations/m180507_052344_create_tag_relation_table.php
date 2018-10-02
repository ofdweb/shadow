<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag_relation`.
 */
class m180507_052344_create_tag_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag_relation', [
            'tag_id' => $this->integer(11)->defaultValue(null),
            'entity' => $this->string(32)->notNull(),
            'entity_id' => $this->integer(11)->unsigned()->defaultValue(null),
        ]);
      
        $this->createIndex('ind_tag_relation_id', '{{%tag_relation}}', 'tag_id');
        $this->createIndex('ind_tag_relation_entity', '{{%tag_relation}}', 'entity');
        $this->createIndex('ind_tag_relation_entity_id', '{{%tag_relation}}', 'entity_id');
      
        $this->addForeignKey('fk_tag_relation_id', '{{%tag_relation}}', 'tag_id', '{{%tag}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag_relation');
    }
}
