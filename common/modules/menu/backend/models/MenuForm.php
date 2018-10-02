<?php

namespace modules\menu\backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use modules\menu\models\Menu;

class MenuForm extends Model
{
    public $link_object = false;
  
    public $title;
  
    public $slug;
  
    public $menu;
  
    public $parent_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'when' => function($model) {
              return !$model->link_object;
            }],
            [['slug'], 'required', 'when' => function($model) {
              return !$model->link_object;
            }],
            [['link_object'], 'boolean'],
            ['parent_id', 'integer'] 
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'link_object' => Yii::t('app', 'Привязать содержимое'),
        ];
    }
  
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->menu = new Menu();      
        parent::init();
    }
  
    /**
     * @inheritdoc
    */
    public function load($data, $formName = null)
    {
        return parent::load($data, $formName) && $this->menu->load($data, $formName);
    }
  
    /**
     * @inheritdoc
    */
    public function afterValidate() 
    {
        $this->menu->validate();
      
        if ($this->menu->hasErrors()) {
            $this->addErrors($this->menu->getErrors());
        }
      
        return parent::afterValidate();
    }
  
    /**
     * @inheritdoc
     */
    public function afterFind ()
    {
        $this->setAttributes([
            //'parent_id' => 3,
            'link_object' => $this->hasEntity
        ]);
        parent::afterFind();
    }
  
    public static function find()
    {
        return Menu::find();
    }
  
    public function findModel($id)
    {
        $model = $this->menu::find()
            ->mainMenu()
            ->with(['status'])
            ->joinWith(['created', 'updated as upd'])
            ->byId($id);
      
        if ($model) {
            $this->menu = $model;
        }

        return $this;
    }
  
    public function getPrimaryKey()
    {
        return $this->menu->id;
    }

    public function save()
    {
        if (!$this->validate()) {
            return $this;
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try {
            if ($this->menu->save()) {
                $transaction->commit();
            } else {
                $transaction->rollBack();
            } 
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this;
    }
}