<?php
namespace common\widgets\nestable;

use voskobovich\tree\manager\widgets\nestable\NestableAsset;
use voskobovich\tree\manager\interfaces\TreeInterface;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Pjax;

class TreeNestable extends Widget
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var array
     */
    public $modelClass;
    /**
     * @var array
     */
    public $nameAttribute = 'title';
    /**
     * Behavior key in list all behaviors on model
     * @var string
     */
    public $behaviorName = 'nestedSetsBehavior';
    /**
     * @var array.
     */
    public $pluginOptions = [];
    /**
     * Url to MoveNodeAction
     * @var string
     */
    public $moveUrl;
    /**
     * Url to CreateNodeAction
     * @var string
     */
    public $createUrl;
    /**
     * Url to UpdateNodeAction
     * @var string
     */
    public $updateUrl;
    /**
     * Url to page additional update model
     * @var string
     */
    public $advancedUpdateRoute;
    /**
     * Url to DeleteNodeAction
     * @var string
     */
    public $deleteUrl;
    /**
     * Handler for render form fields on create new node
     * @var callable
     */
    public $formFieldsCallable;
    /**
     * Структура меню в php array формате
     * @var array
     */
    private $_items = [];
    /**
     * Инициализация плагина
     */
    public function init()
    {
        parent::init();
      
        if (empty($this->id)) {
            $this->id = $this->getId();
        }
        if ($this->modelClass == null) {
            throw new InvalidConfigException('Param "modelClass" must be contain model name');
        }
        if (null == $this->behaviorName) {
            throw new InvalidConfigException("No 'behaviorName' supplied on action initialization.");
        }
        if (null == $this->advancedUpdateRoute && ($controller = Yii::$app->controller)) {
            $this->advancedUpdateRoute = "{$controller->id}/update";
        }
        if ($this->formFieldsCallable == null) {
            $this->formFieldsCallable = function ($form, $model) {
                /** @var ActiveForm $form */
                echo $form->field($model, $this->nameAttribute);
            };
        }
        /** @var ActiveRecord|TreeInterface $model */
        $model = $this->modelClass;
        /** @var ActiveRecord[]|TreeInterface[] $rootNodes */
        $rootNodes = $model::find()->roots()->all();
      
        if (!empty($rootNodes[0])) {
            /** @var ActiveRecord|TreeInterface $items */
            $items = $rootNodes[0]->populateTree();
            $this->_items = $this->prepareItems($items);
        }
    }
    /**
     * @param ActiveRecord|TreeInterface $node
     * @return array
     */
    protected function getNode($node)
    {
        $items = [];
        /** @var ActiveRecord[]|TreeInterface[] $children */
        $children = $node->children;
        foreach ($children as $n => $node) {
            $items[$n]['id'] = $node->getPrimaryKey();
            $items[$n]['name'] = $node->getAttribute($this->nameAttribute);
            $items[$n]['children'] = $this->getNode($node);
            $items[$n]['update-url'] = Url::to([$this->advancedUpdateRoute, 'id' => $node->getPrimaryKey()]);
            $items[$n]['status'] = $node->status->bg_color;
        }
        return $items;
    }
    /**
     * @param ActiveRecord|TreeInterface[] $node
     * @return array
     */
    private function prepareItems($node)
    {
        return $this->getNode($node);
    }
    /**
     * @param null $name
     * @return array
     */
    private function getPluginOptions($name = null)
    {
        $options = ArrayHelper::merge($this->getDefaultPluginOptions(), $this->pluginOptions);
        if (isset($options[$name])) {
            return $options[$name];
        }
        return $options;
    }
    /**
     * Работаем!
     */
    public function run()
    {
        $this->registerActionButtonsAssets();
        $this->actionButtons();
      
        Pjax::begin([
            'id' => $this->id . '-pjax',
            'timeout' => false
        ]);
          $this->registerPluginAssets();
          $this->renderMenu();
        Pjax::end();
    }
    /**
     * Register Asset manager
     */
    private function registerPluginAssets()
    {
        NestableAsset::register($this->getView());
      
        $view = $this->getView();
        $pluginOptions = $this->getPluginOptions();
        $pluginOptions = Json::encode($pluginOptions);
        $view->registerJs("$('#{$this->id}').nestable({$pluginOptions});");
        // language=JavaScript
        $view->registerJs("
          $('#{$this->id}-new-node-form').on('beforeSubmit', function(e){
                    $.ajax({
                        url: '{$this->getPluginOptions('createUrl')}',
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(data, textStatus, jqXHR) {
                          $('#{$this->id}-new-node-modal').modal('hide')
                          $.pjax.reload({container: '#{$this->id}-pjax'});
                          window.scrollTo(0, document.body.scrollHeight);
                        },
                    }).fail(function (jqXHR) {
                        alert(jqXHR.responseText);
                    });
                    return false;
          });
        ");
    }
    /**
     * Register Asset manager
     */
    private function registerActionButtonsAssets()
    {
        $view = $this->getView();
        $view->registerJs("
          $('.{$this->id}-nestable-menu [data-action]').on('click', function(e) {
                    e.preventDefault();
            var target = $(e.target),
                action = target.data('action');
            switch (action) {
              case 'expand-all':
                  $('#{$this->id}').nestable('expandAll');
                  $('.{$this->id}-nestable-menu [data-action=\"expand-all\"]').hide();
                  $('.{$this->id}-nestable-menu [data-action=\"collapse-all\"]').show();
                break;
              case 'collapse-all':
                  $('#{$this->id}').nestable('collapseAll');
                  $('.{$this->id}-nestable-menu [data-action=\"expand-all\"]').show();
                  $('.{$this->id}-nestable-menu [data-action=\"collapse-all\"]').hide();
                break;
            }
          });
        ");
    }
  
    /**
     * Generate default plugin options
     * @return array
     */
    private function getDefaultPluginOptions()
    {
        $options = [];
      
        $controller = Yii::$app->controller;
      
        if ($controller) {
            $options['moveUrl'] = Url::to(["{$controller->id}/moveNode"]);
            $options['createUrl'] = Url::to(["{$controller->id}/createNode"]);
            $options['updateUrl'] = Url::to(["{$controller->id}/updateNode"]);
            $options['deleteUrl'] = Url::to(["{$controller->id}/deleteNode"]);
        }
        if ($this->moveUrl) {
            $this->pluginOptions['moveUrl'] = $this->moveUrl;
        }
        if ($this->createUrl) {
            $this->pluginOptions['createUrl'] = $this->createUrl;
        }
        if ($this->updateUrl) {
            $this->pluginOptions['updateUrl'] = $this->updateUrl;
        }
        if ($this->deleteUrl) {
            $this->pluginOptions['deleteUrl'] = $this->deleteUrl;
        }
        return $options;
    }

    /**
     * Кнопки действий над виджетом
     */
    public function actionButtons()
    {
        echo $this->render('_tree_nestable_buttons', [
          'id' => $this->id
        ]);
    }
    /**
     * Вывод меню
     */
    private function renderMenu()
    {
        echo Html::beginTag('div', ['class' => 'dd-nestable', 'id' => $this->id]);
            echo $this->render('tree_nestable', [
              'level' => $this->_items,
              'id' => $this->id
            ]);
        echo Html::endTag('div');
    }
}
