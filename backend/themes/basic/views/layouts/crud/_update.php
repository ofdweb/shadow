<?php 
$this->beginContent('@theme/layouts/main.php');

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="page-form box box-solid">
    <div class="box-body no-padding">
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
            <?= $content ?>
        <?php ActiveForm::end(); ?>
    </div>
  </div>

<?php $this->endContent(); ?>