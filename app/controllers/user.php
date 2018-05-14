<?php

namespace Controllers;


use Core\Controller;
use Lib\Built\View\View;

class User extends Controller
{

    public function login()
    {
        $this->view = View::getInstance($this->config);
        $this->view->display("user/login");
    }

    public function registry()
    {
        $this->view = View::getInstance($this->config);
        $this->view->display("user/registry");
    }
}