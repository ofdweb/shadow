<?php 
$this->beginContent('@theme/layouts/main.php');
 
$this->params['breadcrumbs'][] = $this->title;
?>

  <div class="page-index box box-primary">
    <div class="box-body">
      <?= $content ?>
    </div>
  </div>

<?php $this->endContent(); ?>