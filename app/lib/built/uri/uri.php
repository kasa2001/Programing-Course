<?php

namespace Lib\Built\URI;

use Core\Router;
use Lib\Built\Get\Get;

class URI
{
    use \GetInstance;

    /**
     * @var $object static URI
     * */
    private static $object;

    /**
     * @var $scheme string
     * */
    private $scheme;

    /**
     * @var $host string
     * */
    private $host;

    /**
     * @var $base string
     * */
    private $base;

    /**
     * @var $requestURI string
     * */
    private $requestURI;

    /**
     * @var $address string
     * */
    private $address;

    /**
     *@var $get array
     */
    private $get;

    private $dir;

    private $controller;

    private $method;

    private $params = [];

    /**
     * Construct create URI object
     * */
    public function __construct()
    {
        $this->dir = dirname($_SERVER['SCRIPT_NAME']);

        $this->get = new Get();

        $matches = explode(
            "/",
            preg_split(
                "/\\". $this->dir . "\//" ,
                explode(
                    "?",
                    $_SERVER['REQUEST_URI']
                )[0]
            )[1]
        );

        $this->controller = !empty($matches[0]) ? $matches[0] : 'home';
        $this->method = !empty($matches[1]) ? $matches[1] : 'index';

        unset($matches[0], $matches[1]);

        foreach ($matches as $param) {
            array_push($this->params, $param);
        }

        $this->scheme = $_SERVER["REQUEST_SCHEME"] . "://";
        $this->host = $_SERVER["HTTP_HOST"];

        $this->requestURI = '/' . $this->controller . '/' . $this->method;

        if (!empty($this->params)) {
            $this->requestURI .= '/' . implode('/', $this->params);
        }

        $this->base = $this->scheme . $this->host . $this->dir;
        $this->address = $this->base . $this->dir . $this->requestURI;

        self::$object = $this;

    }

    /**
     * Method return scheme
     * @return string
     * */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Method return address
     * @return string
     * */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Method return host
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Method return base address
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Method return request URI
     * @return string
     */
    public function getRequestURI()
    {
        return $this->requestURI;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function checkVars()
    {
        return !empty($this->get);
    }

    public function getVar($key)
    {
        return $this->get[$key];
    }

    /**
     * Method prepare link to pagination
     * @return string
     */
    public function toPagination()
    {


        return $this->base . $this->controller. $this->method;
    }

    public function getCurrentPage()
    {
        return $this->address;
    }
}
