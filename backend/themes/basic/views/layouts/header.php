<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only"><?= Yii::t('app', 'Навигация') ?></span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= Html::img(Yii::$app->user->identity->profile->avatarThumb, ['class' => 'user-image', 'alt' => Yii::t('app', 'Профиль')]) ?>
                        <span class="hidden-xs"><?= Yii::$app->user->identity->shortName ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?= Html::img(Yii::$app->user->identity->profile->avatarThumb, ['class' => 'user-image', 'alt' => Yii::t('app', 'Профиль')]) ?>

                            <p>
                                <?= Yii::$app->user->identity->fullName ?>
                                <?= Html::itemsGroup(Yii::$app->user->identity->roles, 'name', 'small'); ?>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(Yii::t('app', 'Профиль'), ['/user/default/view', 'id' => Yii::$app->user->id], ['class' => 'btn btn-default btn-flat']) ?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    Yii::t('app', 'Выход'),
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>
