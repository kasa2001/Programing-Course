<?php

namespace Controllers;


use Core\Controller;
use Lib\Built\Factory\Factory;
use Lib\Built\Post\Post;
use Lib\Built\Server\Server;
use Lib\Built\Session\SessionException;
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
        $user->setType(1);

        $model = new \Models\Logic\User();
        $model->registry($user);

        $server = Server::getInstance();

        $server->redirect(300);
    }

    public function add($params)
    {
        try {
            $session = Factory::getSession();

            $user = new \Models\Tables\User();
            $user->setId($session->getDataWithSession('id'));
        } catch (SessionException $e) {
            $server = Server::getInstance();

            $server->redirect(403, null, "Forbidden");
        } finally {
            $id = $params[0];
            $model = new \Models\Logic\User();
            $model->addToCourse($id, $user);
        }

    }

    public function answer()
    {

    }

    public function listing()
    {
        $model = new \Models\Logic\User();
        $table = new \Models\Tables\User();
        $session = Factory::getSession();
        try {
            $table->setId($session->getDataWithSession('id'));
        } catch (SessionException $e) {
            $server = Server::getInstance();
            $server->redirect(403, "Forbidden");
        }
        $courses = $model->getUserCourse($table);
        echo "<pre>";
        print_r($courses);
        echo "</pre>";
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

    public function removeCourse()
    {

    }

    public function removeQuestion()
    {

    }
}