<?php

namespace Models\Logic;


use Core\Database;
use Core\DatabaseNullException;
use Models\Tables\Category;

class User
{

    public function login($name, $password)
    {
        $database = new Database();
        $user = new \Models\Tables\User();

        $database
            ->select(new class{
                private $id;
                private $nick;
                private $password;
            })
            ->from(new \Models\Tables\User())
            ->where(function() use ($user, $name, $password) {
                return $user->nick == $name && $user->password == $password;
            });
        $database->execute();
        return $database->loadArray();
    }

    public function registry(\Models\Tables\User $user)
    {
        try {
            $this->login($user->nick, $user->password);
            return true;
        } catch (DatabaseNullException $e) {
            $database = new Database();

            $query = "INSERT INTO `user` value ('','$user->nick', '$user->password', '$user->email', '$user->type')";

            $database->execute($query);

            return false;
        }
    }

    public function getCourse()
    {
        $category = new Category();

        $database = new Database();
        $database->select($category)
            ->from($category)
            ->execute();

        return $database->loadArray();
    }

    public function getUserCourse()
    {

    }
}