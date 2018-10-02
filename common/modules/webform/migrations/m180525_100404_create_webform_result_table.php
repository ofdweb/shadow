<?php

use yii\db\Migration;

/**
 * Handles the creation of table `webform_result`.
 */
class m180525_100404_create_webform_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('webform_result', [
            'id' => $this->primaryKey(),
            'form_id' => $this->integer(11)->notNull(),
            'delivery_id' => $this->integer(11)->defaultValue(0),
            'result' => $this->json(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer(11)->defaultValue(0),
        ]);
      
        $this->createIndex('ind_webform_result_form_id', '{{%webform_result}}', 'form_id');
        $this->addForeignKey('fk_webform_result', '{{%webform_result}}', 'form_id', '{{%webform}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('webform_result');
    }
}
