<?php

//TODO

namespace Lib\Built\Cache;

use Lib\Built\View\View;

class Cache
{

    private $directory;

    private $instance;

    public function __construct($directory = "cache", $instance = "standard")
    {
        $this->directory = $directory;
        $this->instance = $instance;
    }

    public function renderFile($file)
    {

    }

    public function renderImage()
    {

    }

    public function renderElement()
    {

    }

    public function getCachedFile($file)
    {
        $view = View::getInstance();
    }

    public function getCachedImage()
    {

    }
}
