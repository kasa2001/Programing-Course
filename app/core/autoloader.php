<?php

namespace Core;

/**
 * Standard core class for Auto loading all classes
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 1.0
 * @package Core
 * */
class AutoLoader
{
    use \GetInstance;
    private static $object;
    private $namespace = array();

    private function __construct($method)
    {
        spl_autoload_extensions(".php");
        spl_autoload_register(array($this, $method));
    }

    /**
     * Method add namespace to autoload
     *
     * @param $namespace string
     * @param $directory string
     * @throws AutoLoaderException if namespace is registered
     *
     * @return boolean
     * */
    public function registerNamespace($namespace, $directory)
    {
        if (isset($this->namespace[$namespace])) {
            throw new AutoLoaderException("Namespace is registered earlier");
        }

        $this->namespace[$namespace] = $directory;

        return true;
    }

    /**
     * Method load classes by PSR-4 standard
     *
     * @param $class string
     * @throws AutoLoaderException if namespace is not registered
     *
     * @return boolean
     * */
    public function loadPSR4($class)
    {
        $class = explode('\\', $class);
        if (!isset($this->namespace[$class[0]])) {
            throw new AutoLoaderException("Page not found",404);
        }
        $item = $class[0];
        unset($class[0]);

        return spl_autoload($this->namespace[$item] . '/' . implode('/', $class));
    }
}
