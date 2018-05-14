<?php

trait GetInstance
{

    public static function getInstance($config = null)
    {
        try {
            $className = __CLASS__;
            $class = new ReflectionClass($className);
            if (empty(self::$object)) {
                $construct = $class->getConstructor();
                $construct->setAccessible(true);
                self::$object = new $className($config);
                $construct->setAccessible(false);
            }
        } catch (Exception $e) {
            $server = \Lib\Built\Server\Server::getInstance($config);
            $server->redirect(500);
            exit();
        }

        return self::$object;
    }
}
