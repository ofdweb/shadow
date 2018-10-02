<?php

use yii\db\Migration;

/**
 * Handles the creation of table `metatag`.
 */
class m180424_185318_create_metatag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('metatag', [
            'entity' => $this->string(32)->notNull(),
            'entity_id' => $this->integer(11)->unsigned()->notNull(),
            'title' => $this->string(64)->defaultValue(null),
            'keywords' => $this->string(64)->defaultValue(null),
            'description' => $this->text()->defaultValue(null),
            'abstract' => $this->text()->defaultValue(null),
            'PRIMARY KEY(entity, entity_id)',
        ]);
        
        $this->createIndex('ind_metatag_entity_id', '{{%metatag}}', 'entity_id');
        $this->createIndex('ind_metatag_entity', '{{%metatag}}', 'entity');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('metatag');
    }
}
