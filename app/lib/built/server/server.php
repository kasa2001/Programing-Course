<?php

namespace Lib\Built\Server;

/**
 * todo!!!
 * */
use Core\Config;
use Lib\Built\Factory\Factory;
use Controllers\Home;

class Server
{
    const ERROR400 = "Bad Request";
    const ERROR401 = "Unauthorized";
    const ERROR402 = "Payment Required";
    const ERROR403 = "Forbidden";
    const ERROR404 = "Page not found";
    const ERROR410 = "Gone";

    private static $object;
    private $uri;

    use \GetInstance;

    private function __construct($data)
    {
        $this->uri = Factory::getInstance('\Lib\Built\URI\URI', $data);
    }

    /**
     * Method redirecting if someone try go to file with JSON
     * */
    public function checkIsJS()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            if (!isset($_SERVER['HTTP_REFERER'])) {
                $this->redirect(null, 403);
            } else {
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    /**
     * Method return data about preview page
     * @return string|null
     * */
    public function getPreviewWebSite()
    {
        try {
            if (!isset($_SERVER['HTTP_REFERER'])) {
                throw new ServerException("Previous page not exists");
            }
        } catch (ServerException $e) {

        }
        return $_SERVER['HTTP_REFERER'];
    }

    /**
     * Method redirect to another page. If $where is null redirect to preview page
     * @param $where string
     * @param $code int
     * @param $message string
     * */
    public function redirect($code = 200, $where = null, $message = null)
    {
        if ($where === null) {
            if ($code > 399) {
                $this->_setError($code);
                $this->_loadErrorPage($message);
            } else {
                $config = new Config();
                $config = $config->getConfig();
                echo "<pre>";
                print_r(isset($config["system"]["default-directory"])? '/' .$config["system"]["default-directory"] :'');
                echo "</pre>";
//                exit;
                header("Location: " . isset($config["system"]["default-directory"])? '/' .$config["system"]["default-directory"] :''. "/home/index");
            }
        } else {
            if ($code > 199 && $code < 400) {
                header("Location: " . $where, true, $code);
            } else {
                header("Location: " . $where);
            }
        }
    }

    /**
     * Method set redirect error
     * @param $code int
     * */
    protected function _setError($code)
    {
        switch ($code) {
            case 404:
                header("HTTP/1.1 404 " . self::ERROR404);
                header("Status: 404 " . self::ERROR404);
                break;
            case 410:
                header("HTTP/1.1 410 " . self::ERROR410);
                header("Status: 410 " . self::ERROR410);
                break;
            case 403:
                header("HTTP/1.1 403 " . self::ERROR403);
                header("Status: 403 " . self::ERROR403);
                break;
            case 402:
                header("HTTP/1.1 402 " . self::ERROR402);
                header("Status: 402 " . self::ERROR402);
                break;
            case 401:
                header("HTTP/1.1 401 " . self::ERROR401);
                header("Status: 401 " . self::ERROR401);
                break;
            default:
                header("HTTP/1.1 400 " . self::ERROR400);
                header("Status: 400 " . self::ERROR400);
                break;
        }
        http_response_code($code);
        $_SERVER['REDIRECT_STATUS'] = $code;
    }

    public static function getStatus()
    {
        return $_SERVER['REDIRECT_STATUS'];
    }

    protected function _loadErrorPage($message)
    {
        call_user_func_array(array(new Home(), "error"), array($message));
    }
}
