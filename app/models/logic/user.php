<?php

namespace Models\Logic;


use Core\Database;
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
        if (!empty($this->login($user->nick, $user->password))) {
            throw new \Exception("Page not fount","404");
        }

        $database = new Database();

        $query = "INSERT INTO `user` value ('','$user->nick', '$user->password', '$user->email', '$user->type')";

        $database->execute($query);
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