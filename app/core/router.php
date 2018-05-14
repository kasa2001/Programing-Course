<?php

namespace Core;

use Lib\Built\Error\Error;

class Router
{

    private static $object;

    use \GetInstance;

    private function __construct()
    {
    }

    /**
     * Method where you can prepare routing. Method this you can add to switch uri (if you not added uri default controller been execute)
     * @param $uri string
     * @throws \Exception if page not found or gone
     * @return string
     * */
    public function checkRoute($uri)
    {
        switch ($uri) {
            case "home/taxonomy":
                throw new \Exception('Gone', 410);
            default:
                return $uri;
        }
    }
}
