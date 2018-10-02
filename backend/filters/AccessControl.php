<?php

namespace backend\filters;

use Yii;
use yii\filters\AccessControl as AccessFilter;

class AccessControl extends AccessFilter
{
    public $rules = [
      [
        'actions' => ['login', 'error', 'gii'],
        'allow' => true,
      ], [
        'allow' => true,
        'roles' => ['admin', 'manager'],
      ],
    ];
 }