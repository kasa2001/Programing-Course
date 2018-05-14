<?php

namespace Lib\Built\Collection;

/**
 * Standard Stack class
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 0.1
 * @package Lib\Build\Collection
 * */
class Stack extends Collection
{
    const EMPTY_STACK = 4;

    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    public function copy()
    {
        return new Stack($this->collection);
    }

    /**
     * Method push object or another variable to Stack
     * @param $object mixed
     */
    public function push($object)
    {
        $this->_check($object);
        array_push($this->collection, $object);
        ++$this->_count;
    }

    /**
     * Method pop object from Stack
     * @return mixed
     * */
    public function pop()
    {
        try {
            if ($this->_count == 0) {
                throw new CollectionException("Empty stack", self::EMPTY_STACK);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        $object = $this->collection[($this->_count - 1)];

        unset($this->collection[$this->_count - 1]);

        --$this->_count;
        return $object;
    }

    /**
     * Method peek how object is first in stack
     * @return mixed
     * */
    public function peek()
    {
        try {
            if ($this->_count == 0) {
                throw new CollectionException("Empty stack", self::EMPTY_STACK);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }

        return $this->collection[($this->_count-1)];
    }
}
