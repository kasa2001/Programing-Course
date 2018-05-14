<?php

namespace Lib\Built\Collection;

/**
 * Standard Map class
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @since 1.0
 * @version 0.1
 * @package Lib\Build\Collection
 * */
class Map extends Collection implements \Iterator
{
    const INDEX_BUSY = 5;
    const MAP_EMPTY = 8;

    private $keys = array();
    private $where;

    public function __construct($data = null, $key = null)
    {
        parent::__construct($data);

        if ($key !== null) {
            if (is_array($key)) {
                foreach ($key as $item) {
                    $this->_checkIndex($item);
                }
            } else {
                $this->_checkIndex($key);
            }

            $this->keys = $key;
        }

        $this->where = 0;
    }

    public function copy()
    {
        return new Map($this->collection, $this->keys);
    }

    public function add($object, $key)
    {
        $this->_check($object);
        $this->_checkIndex($key);
        $this->collection = array_merge($this->collection, array($key => $object));
        array_push($this->keys, $key);
        ++$this->_count;
    }

    public function peek($key)
    {
        try {
            if (!isset($this->collection[$key])) {
                throw new CollectionException("Wrong index", self::WRONG_INDEX);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        return $this->collection[$key];
    }

    public function remove($key)
    {
        try {
            if (!isset($this->collection[$key])) {
                throw new CollectionException("Wrong index", self::WRONG_INDEX);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        unset($this->collection[$key]);

        --$this->_count;
    }

    public function current()
    {
        try {
            if (!isset($this->collection[$this->keys[$this->where]])) {
                throw new CollectionException("Map empty", self::MAP_EMPTY);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        return $this->collection[$this->keys[$this->where]];
    }

    public function next()
    {
        ++$this->where;
    }

    public function key()
    {
        try {
            if (!isset($this->collection[$this->keys[$this->where]])) {
                throw new CollectionException("Map empty", self::MAP_EMPTY);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
        return $this->keys[$this->where];
    }

    public function valid()
    {
        return $this->where < $this->_count;
    }

    public function rewind()
    {
        $this->where = 0;
    }

    protected function _checkIndex($key)
    {
        try {
            if (isset($this->collection[$key])) {
                throw new CollectionException("Index busy", self::INDEX_BUSY);
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
    }
}
