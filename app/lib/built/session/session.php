<?php

namespace Lib\Built\Session;

class Session
{

    /**
     * Construct start session
     * */
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();

            print_r($_SESSION);
        }
    }

    /**
     * Method write data to session
     * @param $data array
     * */
    public function writeToSession($data)
    {
        foreach ($data as $key => $datum) {
            if (!isset($_SESSION[$key])) {
                $_SESSION[$key] = $datum;
            }
        }
    }

    /**
     * Method get data from session
     * @param $data string
     * @throws SessionException if isset session data
     * @return mixed
     * */
    public function getDataWithSession($data)
    {
        if (isset($_SESSION[$data])) {
            return $_SESSION[$data];
        } else {
            throw new SessionException("Błąd wewnętrzny serwera", 500);
        }
    }

    /**
     * Method kill session
     * */
    public function destroySession()
    {
        session_destroy();
    }
}
