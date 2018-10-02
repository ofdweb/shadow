<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m180412_182437_create_article_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'slug' => $this->string(255)->notNull(),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'published_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
        
        $this->addForeignKey('fk_article_created_by', '{{%article}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_article_updated_by', '{{%article}}', 'updated_by', '{{%user}}', 'id');
        
        $this->createTable('article_lang', [
            'entity_id' => $this->integer(11),
            'language' => $this->string(8)->notNull(),
            'title' => $this->string(255)->notNull(),
            'announcement' => $this->text(),
            'description' => $this->text(),
            'PRIMARY KEY(language, entity_id)',
        ]);
        
        $this->createIndex('ind_article_lang_language', '{{%article_lang}}', 'language');
        $this->createIndex('ind_article_lang_entity_id', '{{%article_lang}}', 'entity_id');
        
        $this->addForeignKey('fk_article_lang_entity_id', '{{%article_lang}}', 'entity_id', '{{%article}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article_lang');
        $this->dropTable('article');
    }
}
