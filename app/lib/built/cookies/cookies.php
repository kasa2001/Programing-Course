<?php
/*
 * Class todo later. You can to better plan this out
 * */

namespace Lib\Built\Cookies;

class Cookies
{
    public function __construct()
    {

    }

    public function setCookie($name, $value, $expire)
    {
        setcookie($name, $value, $expire);
    }

    public function getCookie($name)
    {
        return $_COOKIE["$name"];
    }

    public function changeCookie($name, $value, $expire = null)
    {
        if ($expire == null) {
            setcookie($name, $value);
        } else {
            setcookie($name, $value, $expire);
        }

    }

    public function removeCookie($name)
    {
        setcookie($name, "", -1);
    }

    public function checkExist($name)
    {
        return isset($_COOKIE[$name]);
    }
}
