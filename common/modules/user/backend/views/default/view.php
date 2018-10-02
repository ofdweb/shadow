<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Пользователи'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
    <div class="row">
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Профиль'),
                            'content' => $this->render('tabs/_view_profile', compact('model'))
                        ]
                      ],
                  ]); ?>
              </div>
          </div>
          <div class="col-md-3">
              <?= $this->render('tabs/_view_accaunt', compact('model')) ?>
          </div>
    </div>
</div>
