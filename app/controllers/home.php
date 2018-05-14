<?php

/**
 * All new classes must extends which class Controller.
 * */
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
        try {
            $model = new \Models\Logic\User();
            $user = $model->login($post->name, $post->password);
            $session->writeToSession($user);
            echo "Zalogowano";
        } catch (PostException $e) {
            try {
                $data['user'] = (int) $session->getDataWithSession("id");
            } catch (SessionException $e) {
                $data['user'] = false;
            }
        } finally {
            $this->view = View::getInstance($this->config);
            $this->view->display("home/index", $data);
        }
    }

}
