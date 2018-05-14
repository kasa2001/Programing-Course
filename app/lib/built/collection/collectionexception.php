<?php

namespace Lib\Built\Collection;

/**
 * Standard Collection Exception
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 1.0
 * @package Lib\Build\Collection
 * */
class CollectionException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
