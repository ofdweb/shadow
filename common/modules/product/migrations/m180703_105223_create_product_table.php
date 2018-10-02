<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m180703_105223_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'weight' => $this->integer(11),
            'relise_date' => $this->smallInteger(4),
            'slug' => $this->string(255)->notNull(),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'published_at' => $this->integer(11),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
        
        $this->addForeignKey('fk_product_created_by', '{{%product}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_product_updated_by', '{{%product}}', 'updated_by', '{{%user}}', 'id');
        
        $this->createTable('product_lang', [
            'entity_id' => $this->integer(11),
            'language' => $this->string(8)->notNull(),
            'title' => $this->string(255)->notNull(),
            'announcement' => $this->text(),
            'description' => $this->text(),
            'PRIMARY KEY(language, entity_id)',
        ]);
        
        $this->createIndex('ind_product_lang_language', '{{%product_lang}}', 'language');
        $this->createIndex('ind_product_lang_entity_id', '{{%product_lang}}', 'entity_id');
        
        $this->addForeignKey('fk_product_lang_entity_id', '{{%product_lang}}', 'entity_id', '{{%product}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_lang');
        $this->dropTable('product');
    }
}
