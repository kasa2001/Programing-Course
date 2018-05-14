<?php

namespace Core;

use Lib\Built\Server\Server;
use Lib\Built\View\View;
use Models;

class Controller extends Config
{
    /**
     * @var $view View
     * */
    protected $view;

    /**
     * @var $server Server
     * */
    protected $server;

    /**
     * Method where add model and connect whit database if exists $_POST
     * @param $model string how model
     * @return Database. Return new model from view
     * @deprecated  model can be loaded by PSR-4 standard
     * */
    public function loadModel($model)
    {
        return new  $model();
    }

    /**
     * Method return  not associative array
     * @param $array array
     * @return array
     * */
    public function indexedData($array)
    {
        $i = 0;
        $data = [];
        foreach ($array as $value) {
            $data[$i] = $value;
            $i++;
        }
        return $data;
    }
}
