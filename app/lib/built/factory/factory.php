<?php

namespace Lib\Built\Factory;

use Lib\Built\SEO\SEO;
use Lib\Built\Mail\Mail;
use Lib\Built\Session\Session;
use Modules\Built\Pagination\Pagination;
use Lib\Built\Date\Date;
use Core\Database;

class Factory
{
    public static function getInstance($class, $data)
    {
        return $class::getInstance($data);
    }

    public static function getDatabase($driver = null, $host = null, $db = null, $user = null, $password = null)
    {
        return new Database($driver, $host, $db, $user, $password);
    }

    public static function getMail($data)
    {
        return Mail::getInstance($data);
    }

    public static function getPagination($data)
    {
        return Pagination::getInstance($data);
    }

    public static function getSEO($data)
    {
        return SEO::getInstance($data);
    }

    public static function getDate($data = null)
    {
        return new Date($data);
    }

    public static function getSession()
    {
        return new Session();
    }
}
