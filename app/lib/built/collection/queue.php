<?php

namespace Lib\Built\Collection;

/**
 * Standard Queue class
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 0.1
 * @package Lib\Build\Collection
 * */
class Queue extends Collection
{
    const EMPTY_QUEUE = 7;

    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    public function copy()
    {
        return new Queue($this->collection);
    }

    public function enQueue($object)
    {
        $this->_check($object);
        array_push($this->collection, $object);
        ++$this->_count;
    }

    public function deQueue()
    {
        try {
            if ($this->_count == 0) {
                throw new CollectionException("Empty Queue", self::EMPTY_QUEUE);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        $object = $this->collection[0];
        unset($this->collection[0]);
        $this->collection = array_values($this->collection);
        --$this->_count;
        return $object;
    }

    public function peek()
    {
        try {
            if (!isset($this->collection[0])) {
                throw new CollectionException("Empty Queue", self::EMPTY_QUEUE);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        return $this->collection[0];
    }
}
