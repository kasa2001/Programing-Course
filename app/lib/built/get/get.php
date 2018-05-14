<?php

namespace Lib\Built\Get;


class Get
{

    private $get;

    public function __construct()
    {
        $this->get = $_GET;
    }


    public function __get($name)
    {
        if (isset($this->get[$name]))
            return $this->get[$name];
        else
            throw new GetException("Błąd serwera", 500);
    }

}