<?php

namespace Core;

use Lib\Built\Collection\ArrayList;
use Lib\Built\Collection\Map;
use Lib\Built\Collection\Queue;
use Lib\Built\Collection\Stack;
use Lib\Built\StdObject\StdObject;

/**
 * Standard core class for connecting and execute all queries</br>
 *
 * @author Paweł Gomółka (kasa2001) <pawelgomolka@interia.pl>
 * @uses ArrayList, Map, Queue, Stack, StdObject
 * @since 1.0
 * @version 0.1
 * @package Core
 * @todo  Prepare unit test
 * @todo  Prepare update
 * @todo  Prepare delete
 * @todo  Prepare join
 * */
class Database extends Config
{
    /**
     * @var \PDOStatement
     * */
    protected $data;

    /**
     * @var \PDO
     * */
    protected $connect;

    /**
     * @var string
     * */
    protected $driver;

    /**
     * @var string
     * */
    protected $server;

    /**
     * @var string
     * */
    protected $login;

    /**
     * @var string
     * */
    protected $password;

    /**
     * @var string
     * */
    protected $base;

    /**
     * @var array
     * */
    protected $select = array();

    /**
     * @var array
     * */
    protected $from = array();

    /**
     * @var array
     * */
    protected $where = array();

    /**
     * @var array
     * */
    protected $join = array();

    /**
     * @var string
     * */
    protected $method;

    private $queue;

    /**
     * @var string
     * */
    protected $class;

    /**
     * Connect with database
     * @param $driver string/null
     * @param $host string/null
     * @param $db string/null
     * @param $user string/null
     * @param  $password string/null
     * */
    public function __construct($driver = null, $host = null, $db = null, $user = null, $password = null)
    {
        parent::__construct();
        $this->server = ($host === null) ? $this->config['database']['host'] : $host;
        $this->login = ($user === null) ? $this->config['database']['user'] : $user;
        $this->password = ($password === null) ? $this->config['database']['password'] : $password;
        $this->base = ($db === null) ? $this->config['database']['database'] : $db;
        $this->driver = ($driver === null) ? $this->config['database']['sql'] : $driver;
        try {
            $this->connect = new \PDO($this->driver . ":host=" . $this->server . ";charset=utf8;dbname=" . $this->base, $this->login, $this->password);
        } catch (\PDOException $exception) {
            echo '<pre>';
            print_r($exception);
            echo '</pre>';
        }

        $this->queue = new Queue();
    }

    /**
     * Method get data from Database class to array
     * @return array
     * */
    public function loadArray()
    {
        return $this->data->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Method get data from Database class to Queue
     * @return Queue
     * */
    public function loadQueue()
    {
        $queue = new Queue();
        $item = $this->data->fetch(\PDO::FETCH_ASSOC);
        $object = new StdObject();
        foreach ($item as $data) {
            foreach ($data as $key => $i) {
                $object->$key = $i;
            }
            $queue->enQueue($object);
        }

        return $queue;
    }

    /**
     * Method get data from Database class to Stack
     * @return Stack
     * */
    public function loadStack()
    {
        $stack = new Stack();
        $item = $this->data->fetch(\PDO::FETCH_ASSOC);
        $object = new StdObject();
        foreach ($item as $data) {
            foreach ($data as $key => $i) {
                $object->$key = $data;
            }
            $stack->push($object);
        }

        return $stack;
    }

    /**
     * Method get data from Database class to Map
     * @return Map
     * */
    public function loadMap()
    {
        $map = new Map();
        $item = $this->data->fetch(\PDO::FETCH_ASSOC);
        $object = new StdObject();
        foreach ($item as $key => $data) {
            foreach ($data as $keys => $datum) {
                $object->$keys = $datum;
            }
            $map->add($object, $key);
        }

        return $map;
    }

    /**
     * Method get data from Database class to List
     * @return ArrayList
     * */
    public function loadList()
    {
        $list = new ArrayList();
        $item = $this->data->fetch(\PDO::FETCH_ASSOC);
        $object = new StdObject();
        foreach ($item as $data) {
            foreach ($data as $key => $i) {
                $object->$key = $i;
            }
            $list->add($object);
        }

        return $list;
    }

    /**
     * Method return 1 if query is empty or 0 if not empty
     * @return boolean
     * */
    public function isEmpty()
    {
        return $this->data->rowCount() == 0;
    }

    /**
     * Method execute query
     * @param $query string
     */
    public function execute($query = null)
    {
        if ($query === null) {
            $this->data = $this->connect->query($this->renderQuery());
        } else {
            $this->data = $this->connect->query($query);
        }
    }

    /*
     * Methods TODO
     * */

    /**
     * Method get class properties
     * @param $object mixed
     * @throws DatabaseException if is not a object
     * @throws \ReflectionException if class not exists
     * @return $this
     * */
    public function select($object)
    {
        if (is_array($object)) {

            foreach ($object as $class) {
                if (is_object($class)) {
                    $this->renderSelect(new \ReflectionClass($class));
                } else {
                    throw new DatabaseException("Internal Server Error", 500);
                }

            }

        } elseif (is_object($object)) {

            $this->renderSelect(new \ReflectionClass($object));

        } else {
            throw new DatabaseException("Internal Server Error", 500);
        }

        return $this;
    }

    protected function renderSelect(\ReflectionClass $reflect)
    {
        $assoc = null;
        $fields = $reflect->getProperties(
            \ReflectionProperty::IS_PROTECTED
            | \ReflectionProperty::IS_PRIVATE
            | \ReflectionProperty::IS_PUBLIC
        );

        if (strpos(' ' . $reflect->getName(), 'class@anonymous')) {
            $assoc = strtolower($reflect->getName());
        } else {
            $assoc = strtolower($reflect->getShortName());
        }

        $this->select[$assoc] = array();

        foreach ($fields as $field) {
            array_push($this->select[$assoc], $field->name);
        }
    }

    /**
     * Method get class name to query
     * @param $object mixed
     * @throws DatabaseException if is not a object (or array)
     * @throws \ReflectionException if class not exists
     * @return $this
     * */
    public function from($object)
    {
        if (is_array($object)) {

            foreach ($object as $class) {

                if (is_object($class)) {
                    $this->renderFrom(new \ReflectionClass($class));
                } else {
                    throw new DatabaseException("Internal Server Error", 500);
                }
            }

        } elseif (is_object($object)) {

            $this->renderFrom(new \ReflectionClass($object));

        } else {
            throw new DatabaseException("Internal Server Error", 500);
        }

        return $this;
    }

    protected function renderFrom(\ReflectionClass $class)
    {
        $assoc = strtolower($class->getShortName());
        array_push($this->from, $assoc);
        if (!isset($this->select[$assoc])) {

            foreach ($this->select as $key => $value) {

                if (strpos(' ' . $key, 'class@anonymous')) {
                    $this->select[$assoc] = array();

                    foreach ($value as $item) {
                        array_push($this->select[$assoc], $item);
                    }

                    unset($this->select[$key]);
                    break;
                }
            }
        }
    }

    /**
     * Method add where
     * @param $callable \Closure
     * @return $this
     * @throws DatabaseException if not a function
     * @throws \ReflectionException if class not exists
     * */
    public function where($callable)
    {
        if (!is_callable($callable)) {
            throw new DatabaseException('Not Implemented', 501);
        }

        $object = new \ReflectionFunction($callable);

        $params = $object->getStaticVariables();

        $body = $this->getFunctionBody($this->parseFunction($object));

        $this->where = $this->renderCondition($body, $params);

        return $this;
    }

    protected function getFunctionBody($function)
    {
        preg_match('/return[^;]*/', $function, $matches);
        return str_replace('return', '', $matches[0]);
    }

    /**
     * @param $object \ReflectionFunctionAbstract
     * @return string
     * */
    protected function parseFunction(\ReflectionFunctionAbstract $object)
    {
        $file = $object->getFileName();
        $start = $object->getStartLine() - 1;
        $end = $object->getEndLine();
        $length = $end - $start;
        $source = file($file);
        $body = implode("", array_slice($source, $start, $length));
        $matches = array();
        preg_match("/function(?:[^\(]*?)\(\)[^{]*?{[^}]*?}/", $body, $matches);
        return $matches[0];
    }

    /**
     * @param $body
     * @param $params
     * @param $replaced
     * @throws DatabaseException
     * @throws \ReflectionException
     * @return string
     */
    protected function renderCondition($body, $params, $replaced = 1)
    {
        $body = str_replace('$', '', $body);

        foreach ($params as $key => $item) {

            if (is_object($item) && strpos(" " . $body, $key)) {
                $body = $this->prepareCondition($body, $key, $item, $params);
            } elseif (!is_object($item)) {
                $this->method = $item;
                $body = preg_replace_callback('/[^>](' . $key . ')/', array($this, 'params'), $body, $replaced);
            } else {
                throw new DatabaseException("Internal Server Error", 500);
            }

        }

        $body = preg_replace_callback('/[^->]->([A-Za-z]{1,})/', array($this, 'field'), $body);

        return str_replace('==', '= ', $body);
    }

    protected function field($matches)
    {
        return '`.`' . $matches[1] . '`';
    }

    protected function params()
    {
        return '\'' . $this->method . '\'';
    }

    /**
     * @throws \ReflectionException
     * @return string
     * */
    protected function getClassName()
    {
        $class = new \ReflectionClass($this->method);
        return '`' . strtolower($class->getShortName()) . '`';
    }

    /**
     * @param $body
     * @param $key
     * @param $item
     * @param $params
     * @param $replaced
     * @throws \ReflectionException
     * @throws DatabaseException
     * @return string
     * */
    protected function prepareCondition($body, $key, $item, $params, $replaced = 1)
    {
        $method = null;
        $class = new \ReflectionClass($item);
        preg_match_all('/' . $key . '[^->]*?->([A-Za-z]{1,})\(\)/', $body, $matches);

        if (empty($matches[1])) {
            $replaced = substr_count($body, $key);
            $this->method = $item;
            return preg_replace_callback('/' . $key . '/', array($this, 'getClassName'), $body, $replaced);
        }

        $matches = $matches[1];

        for ($i = 0; $i < count($matches); $i++) {
            if ($class->hasMethod($matches[$i])) {
                $method = $class->getMethod($matches[$i]);
            } elseif (count($params) >= $i + 1) {
                throw new DatabaseException("Not implemented", 501);
            } else {
                continue;
            }

            $this->class = $class->getShortName();
            $this->method = $this->getFunctionBody($this->parseFunction($method));
            $body = preg_replace_callback('/' . $key . '[^->|<|=|>]*?->([A-Za-z]{1,})\(\)/', array($this, 'replace'), $body, $replaced);
        }

        return $body;
    }

    /**
     * @return string
     * */
    protected function replace()
    {
        preg_match('/[^->]*?$/', $this->method, $item);
        return '`' . strtolower($this->class) . '`' . '.' . $item[0];
    }

    public function set()
    {
        return $this;
    }

    public function update()
    {
        return $this;
    }

    public function leftJoin()
    {
        return $this;
    }

    public function innerJoin()
    {
        return $this;
    }

    public function rightJoin()
    {
        return $this;
    }

    public function renderQuery()
    {
        $query = '';
        if (!empty($this->select)) {
            $query .= 'SELECT';
            foreach ($this->select as $table => $columns) {
                foreach ($columns as $column) {
                    $query .= " `$table`.`$column`,";
                }
            }
            $query = rtrim($query, ',');
        }

        if (!empty($this->from)) {
            $query .= " FROM";
            foreach ($this->from as $from) {
                $query .= " `$from`,";
            }
            $query = rtrim($query, ',');
        }

        if (!empty($this->where)) {
            $query .= " WHERE $this->where";
        }

        return $query;
    }
}
