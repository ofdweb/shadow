<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use common\widgets\Pjax;
use common\grid\GridView;

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index box box-primary">
  <?= "<?php Pjax::begin(['isGrid' => true, 'options' => ['class' => 'box-body']]); ?>\n"?>  
<?php

if ($generator->indexWidgetType === 'grid'):
    echo "        <?= " ?>GridView::widget([
            'dataProvider' => $dataProvider,
            'filters' => [
                    [
                        'attribute' => 'search', 
                        'class' => 'common\grid\FilterSearchColumn'
                    ],
                    'status_id'
            ],
            <?= !empty($generator->searchModelClass) ? "'layout' => \"{form_filter}\\n{items}\\n{summary}\\n{pager}\",\n            'columns' => [\n" : "'layout' => \"{items}\\n{summary}\\n{pager}\",\n            'columns' => [\n"; ?>
                ['class' => 'yii\grid\CheckboxColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "                '" . $name . "',\n";
        } else {
            echo "                // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "                '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "                // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>
            ],
        ]); ?>
<?php endif; ?>
  <?= "<?php Pjax::end(); ?>\n" ?>
</div>
