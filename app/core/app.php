<?php

namespace Core;

use \Lib\Built\Server\Server;
use Lib\Built\URI\URI;

class App
{
    protected $uri;

    /**
     * @var Router
     * */
    protected $router;

    public function __construct()
    {
        $this->uri = new URI();
    }


    public function render()
    {
        $router = new \Lib\Built\Router\Router(
            $this->uri->getController(),
            $this->uri->getMethod(),
            $this->uri->getParams()
        );

        $router->execute();
    }

    /**
     * Method where get url
     * */
    public function parseUrl()
    {
        $this->router = Router::getInstance(null);
        $url = $this->router->checkRoute(isset($_GET['url']) ? $_GET["url"] : '');
        return explode('/', $url);
    }
}
