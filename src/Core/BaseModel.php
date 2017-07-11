<?php

namespace Core;

use Config\DbConfig;

abstract class BaseModel
{
    public $model;

    public function __construct()
    {
        $config = new DbConfig();
        $this->model = new ActiveRecord($config->config);
    }
}
