<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m180507_051856_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tag', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64)->defaultValue(null),
            'type' => $this->smallInteger(4)->defaultValue(0),
            'created_at' => $this->integer(11)->unsigned(),
            'updated_at' => $this->integer(11)->unsigned(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
      
        $this->addForeignKey('fk_tag_created_by', '{{%tag}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_tag_updated_by', '{{%tag}}', 'updated_by', '{{%user}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }
}
