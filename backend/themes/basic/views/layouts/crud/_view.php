<?php
$this->beginContent('@theme/layouts/main.php');

$this->params['breadcrumbs'][] = $this->title;
?>
  <div class="page-view box box-primary">
      <div class="box-body table-responsive no-padding">
          <?= $content ?>
      </div>
  </div>

<?php $this->endContent(); ?>