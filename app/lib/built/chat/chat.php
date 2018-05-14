<?php

namespace Lib\Built\Chat;

// TODO!!!
class Chat
{
    private static $object;

    /**/
    private $model;

    use \GetInstance;

    private function __construct($model)
    {
        $this->model = $model;
    }

    public function sendMessage()
    {

    }

    public function getMessage()
    {

    }

    public function sendVideoMessage()
    {

    }

    public function getVideoMessage()
    {

    }

    public function sendVoiceMessage()
    {

    }

    public function getVoiceMessage()
    {

    }
}
