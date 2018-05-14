<?php

namespace Lib\Built\Error;

use Lib\Built\Server\Server;

class Error
{
    /**
     * @var $server Server
     * */
    private static $server;

    public static function raiseError($code, $message = null)
    {
        self::$server = Server::getInstance(null);
        self::$server->redirect($code, null, $message);
        exit();
    }
}
