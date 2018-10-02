<?php
use yii\helpers\Html;
use lo\modules\noty\Wrapper;
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);
  
    backend\themes\basic\assets\ThemeAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600" rel="stylesheet">
        <?php $this->head() ?>
    </head>
    <body class="hold-transition sidebar-minsi skin-black fixed">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
    
    <?= Wrapper::widget([
        'layerClass' => 'lo\modules\noty\layers\Toastr',
        // default options
        'options' => [
           'closeButton' => false,
           'debug' => false,
           'newestOnTop' => true,
    
            // and more for this library...
        ],
    ]); ?>

      <?php 
$script = <<< PJAX
    $(document).on('pjax:complete', function (event, xhr, textStatus, options) {
        var url = xhr.getResponseHeader('X-Pjax-Url');console.log(url);
        if (url) {
            window.location.href = url;
        }
    });

PJAX;

//$this->registerJs($script);  
      ?>

    <?php $this->endBody() ?>
    
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
