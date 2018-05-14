<?php

namespace Lib\Built\Collection;

/**
 * Abstract collection class
 *
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @version 0.1
 * @since 1.0
 * @todo change _getError method
 * @package Lib\Build\Collection
 * */
abstract class Collection implements \JsonSerializable, \Countable
{
    const WRONG_INDEX = 1;
    const WRONG_OBJECT = 2;
    const WRONG_SORT = 3;

    /**
     * @var $collection array
     * */
    protected $collection = array();

    /**
     * @var $_count int
     * */
    protected $_count = 0;

    /**
     * Construct create new Collection object
     * @param $data mixed (default null)
     * */
    public function __construct($data = null)
    {
        if ($data !== null) {
            $this->collection = $data;
            $this->_check($data);
            $this->_count = count($data);

        } else {
            $this->_count = 0;
        }
    }

    /**
     * Method clear Collection
     * */
    public function clear()
    {
        $this->collection = array();
        $this->_count = 0;
    }

    /**
     * Method copy Collection
     * @return Collection
     * */
    abstract public function copy();

    /**
     * Method return array of object
     * @return array
     * */
    public function toArray()
    {
        return $this->collection;
    }

    /**
     * Method return array for json serialize
     * @return array
     * */
    public function jsonSerialize()
    {
        return $this->collection;
    }

    /**
     * Method return how many object is in Collection
     * @return int
     * */
    public function count()
    {
        return $this->_count;
    }

    /**
     * Method merge Collection
     * @param $collection Collection
     * */
    public function merge($collection)
    {
        $array = $collection->toArray();
        $this->_check($array);
        $this->collection = array_merge($this->collection, $array);
        $collection->clear();
    }

    /**
     * Method get Collection Exception data
     * @param $e CollectionException
     * */
    protected function _getError($e)
    {
        echo "Collection Exception <br/>";
        echo "Code: " . $e->getCode() . " <br/>";
        echo "Message: " . $e->getMessage() . " <br/>";
        echo "Stack Trace: <br>";
        echo "<pre>";
        print_r($e->getTrace());
        echo "</pre>";

        exit($e->getCode());
    }

    /**
     * Method check type of object
     * @param $data array|object
     * */
    protected function _check($data)
    {
        if ($this->_count != 0) {
            $this->_type($data);
        } elseif (is_array($data)) {
            $this->_type($data);
        }
    }

    /**
     * Method check type of data when pushed to collection
     * @param $data array
     * @param $get mixed
     * */
    protected function _type($data, $get = null)
    {
        if (is_array($data)) {
            $type = null;
            foreach ($data as $datum) {
                $get = gettype($datum);
            }
            if ($get == "object") {
                $type = null;
                foreach ($this->collection as $collection) {
                    $type = get_class($collection);
                    break;
                }
                $this->_loopObject($data, $type);
            } else {
                $type = gettype($this->collection[0]);
                $this->_loopVariable($data, $type);
            }
        } else {
            if (gettype($data) == "object") {
                $type = null;
                foreach ($this->collection as $collection) {
                    $type = get_class($collection);
                    break;
                }
                $this->_loopObject($data, $type);
            } else {
                $type = gettype($this->collection[0]);
                $this->_loopVariable($data, $type);
            }
        }
    }

    /**
     * Method check all data in array (object)
     * @param $data array
     * @param $type string
     * */
    protected function _loopObject($data, $type)
    {
        try {
            if (!is_array($data)) {
                if (get_class($data) != $type) {
                    throw new CollectionException("Wrong object added to collection", self::WRONG_OBJECT);
                }
            } else {
                foreach ($data as $item) {
                    if (get_class($item) != $type) {
                        throw new CollectionException("Wrong object added to collection", self::WRONG_OBJECT);
                    }
                }
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
    }

    /**
     * Method check all data in array (another variable)
     * @param $data array
     * @param $type string
     * */
    protected function _loopVariable($data, $type)
    {
        try {
            if (!is_array($data)) {
                if (gettype($data) != $type) {
                    throw new CollectionException("Wrong variable added to collection", self::WRONG_OBJECT);
                }
            } else {
                foreach ($data as $item) {
                    if (gettype($item) != $type) {
                        throw new CollectionException("Wrong variable added to collection", self::WRONG_OBJECT);
                    }
                }
            }
        } catch (CollectionException $e) {
            $this->_getError($e);
        }
    }
}
