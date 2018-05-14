<?php

namespace Lib\Built\Chat;

class ChatException extends \Elxception
{

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
