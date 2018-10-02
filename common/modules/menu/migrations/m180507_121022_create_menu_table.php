<?php

use yii\db\Migration;
use modules\menu\models\Menu;
/**
 * Handles the creation of table `menu`.
 */
class m180507_121022_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->defaultValue(null),
            'status_id' => $this->smallInteger(4)->defaultValue(10),
            'tree' => $this->integer(11)->defaultValue(null),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'entity' => $this->string(32)->defaultValue(null),
            'entity_id' => $this->integer(11)->unsigned()->defaultValue(null),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'created_by' => $this->integer(11),
            'updated_by' => $this->integer(11),
        ]);
      
        $this->createIndex('lft', '{{%menu}}', ['tree', 'lft', 'rgt']);
        $this->createIndex('rgt', '{{%menu}}', ['tree', 'rgt']);
        $this->createIndex('ind_menu_tree', '{{%menu}}', 'tree');
      
        $this->addForeignKey('fk_menu_created_by', '{{%menu}}', 'created_by', '{{%user}}', 'id');
        $this->addForeignKey('fk_menu_updated_by', '{{%menu}}', 'updated_by', '{{%user}}', 'id');
      
        $model = new Menu(['title' => 'Главное меню', 'tree' => 1]);
        $model->makeRoot()->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('menu');
    }
}
