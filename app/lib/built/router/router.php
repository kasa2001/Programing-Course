<?php


namespace Lib\Built\Router;

use Lib\Built\URI\URI;

/**
 * Standard class for routing.
 * */
class Router
{
    private $class;
    private $method;
    private $params;

    public function __construct($class, $method, $params = false)
    {
        $this->method = $method;
        $this->class = 'Controllers\\' . $class;
        $this->params = $params;
    }

    public function renderRoute()
    {
        $uri = URI::getInstance();

        $link = $uri->getBase();
        $link .= '/' . $this->class;
        $link .= '/' . $this->method;

        if (!empty($this->params)) {
            foreach ($this->params as $param) {
                $link .= '/' . $param;
            }
        }

        return $link;
    }

    /**
     * @throws \ReflectionException if method not exists
     * */
    public function execute()
    {
        $reflection = new \ReflectionMethod($this->class, $this->method);
        $reflection->invoke(new $this->class, $this->params);
    }
}