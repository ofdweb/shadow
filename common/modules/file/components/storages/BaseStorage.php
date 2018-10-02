<?php

namespace modules\file\components\storages;

use Yii;
use yii\base\BaseObject;

abstract class BaseStorage extends BaseObject
{
    public static $styleList = ['ThumbStyle', 'PageStyle', 'ProductThumbStyle', 'ProductStyle', 'CatalogStyle'];
  
    public $uri;
}