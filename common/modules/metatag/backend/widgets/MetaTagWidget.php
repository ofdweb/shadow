<?php

namespace modules\metatag\backend\widgets;

use Yii;
use yii\base\Widget;
use modules\metatag\models\Metatag;

class MetaTagWidget extends Widget
{
    public $model;
  
    public $form;

    public function run()
    {
       // $model = $this->model->metatag ?: new Metatag(['title' => '{title} | {siteName}']);

        return $this->render('meta_tag', [
            'model' => $this->model->metatag,
            'form' => $this->form,
        ]);
    }
}