<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page_lang`.
 */
class m180507_091007_create_page_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page_lang', [
            'entity_id' => $this->integer(11),
            'language' => $this->string(8)->notNull(),
            'title' => $this->string(255)->notNull(),
            'announcement' => $this->text(),
            'description' => $this->text(),
            'PRIMARY KEY(language, entity_id)',
        ]);
      
        $this->createIndex('ind_page_lang_language', '{{%page_lang}}', 'language');
        $this->createIndex('ind_page_lang_entity_id', '{{%page_lang}}', 'entity_id');
        
        $this->addForeignKey('fk_page_lang_entity_id', '{{%page}}', 'id', '{{%page_lang}}', 'entity_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page_lang');
    }
}
