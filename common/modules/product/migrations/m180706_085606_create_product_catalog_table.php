<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_catalog`.
 */
class m180706_085606_create_product_catalog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product_catalog', [
            'product_id' => $this->integer(11),
            'category_id' => $this->integer(11),
        ]);
        
        $this->createIndex('ind_product_catalog_pid', '{{%product_catalog}}', 'product_id');
        $this->createIndex('ind_product_catalog_cid', '{{%product_catalog}}', 'category_id');
        
        $this->addForeignKey('fk_product_catalog_id', '{{%product_catalog}}', 'product_id', '{{%product}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product_catalog');
    }
}
