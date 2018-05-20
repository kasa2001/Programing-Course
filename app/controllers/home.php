<?php

namespace Controllers;

use Core\Controller;
use Lib\Built\Factory\Factory;
use Lib\Built\Post\Post;
use Lib\Built\Post\PostException;
use Lib\Built\Session\SessionException;
use Lib\Built\View\View;

class Home extends Controller
{
    public function index()
    {
        $post = new Post();
        $session = Factory::getSession();
        $data = [];
        $model = new \Models\Logic\User();

        try {
            $user = $model->login($post->name, $post->password);
            $session->writeToSession($user);
        } catch (PostException $e) {
            try {
                $data['user'] = (int) $session->getDataWithSession("id");
            } catch (SessionException $e) {
                $data['user'] = false;
            }
        } finally {

            $data['course'] = $model->getCourse();

            $this->view = View::getInstance($this->config);
            $this->view->display("home/index", $data);
        }
    }

    public function course($params)
    {
        $model = new \Models\Logic\Home();
        $session = Factory::getSession();

        try {
            $data['user'] = $session->getDataWithSession('id');
        } catch (SessionException $e) {
            $data['user'] = false;
        } finally {
            $data['courses'] = $model->getCourse($params[0]);

            $this->view = View::getInstance($this->config);
            $this->view->display("home/course", $data);
        }
    }

    public function courses()
    {
        $model = new \Models\Logic\Home();
        $session = Factory::getSession();
        $data = $model->getCourses();

        try {
            $data['user'] = $session->getDataWithSession('id');
        } catch (SessionException $e) {
            $data['user'] = false;
        } finally {
            $data['courses'] = $model->getCourses();

            $this->view = View::getInstance($this->config);
            $this->view->display("home/courses", $data);
        }
    }


}
