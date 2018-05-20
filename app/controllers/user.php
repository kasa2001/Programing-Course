<?php

namespace Controllers;


use Core\Controller;
use Lib\Built\Post\Post;
use Lib\Built\Server\Server;
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

    public function confirm()
    {
        $post = new Post();
        $user = new \Models\Tables\User();
        $user->setNick($post->nick);
        $user->setEmail($post->email);
        $user->setPassword($post->password);
        $user->setType(0);

        $model = new \Models\Logic\User();
        $model->registry($user);

        $server = Server::getInstance();
        //REDIRECT !!!
        $server->redirect(204);
    }

    public function listing()
    {

    }

    public function index()
    {

    }

    public function course()
    {

    }

    public function selectCourse()
    {

    }

    public function checkCourse()
    {

    }

    public function addCourse()
    {

    }

    public function changeTypeUser()
    {

    }

    public function renderReport()
    {

    }

    public function addCategory()
    {

    }

    public function addQuestion()
    {

    }

    public function addAnswer()
    {

    }
}