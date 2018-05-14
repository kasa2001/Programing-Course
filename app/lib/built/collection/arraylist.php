<?php

namespace Lib\Built\Collection;

/**
 * Standard ArrayList class
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 0.1
 * @package Lib\Build\Collection
 * */
class ArrayList extends Collection implements \Iterator
{

    const INDEX_NOT_EXISTS = 6;
    private $key;

    public function __construct($data = null)
    {
        parent::__construct($data);
        $this->key = 0;
    }

    public function copy()
    {
        return new ArrayList($this->collection);
    }

    public function add($object)
    {
        $this->_check($object);
        array_push($this->collection, $object);
        ++$this->_count;
    }

    public function current()
    {
        try {
            if (!isset($this->collection[$this->key])) {
                throw new CollectionException("Index not exists", self::INDEX_NOT_EXISTS);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }

        return $this->collection[$this->key];
    }

    public function next()
    {
        $this->key++;
    }

    public function key()
    {
        return $this->key;
    }

    public function valid()
    {
        return ($this->key < ($this->_count));
    }

    public function rewind()
    {
        $this->key = 0;
    }

    public function remove($key = null)
    {
        try {
            if ($key != null && !isset($this->collection[$key])) {
                throw new CollectionException('Wrong Index', self::WRONG_INDEX);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }

        if ($key == null) {
            $this->rewind();
        } else {
            $this->key = $key;
        }

        unset($this->collection[$this->key]);
        $this->collection = array_values($this->collection);
        -- $this->_count;
    }

    public function get($index)
    {
        try {
            if (!isset($this->collection[$index])) {
                throw new CollectionException("Wrong index", self::WRONG_INDEX);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        return $this->collection[$index];
    }
}
