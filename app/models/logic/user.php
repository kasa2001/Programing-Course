<?php

namespace Models\Logic;


use Core\Database;
use Core\DatabaseNullException;
use Models\Tables\Category;
use Models\Tables\Usercourse;

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

    public function isSavedToCourse(int $id, \Models\Tables\User $user)
    {
        $temp = $user->id;
        $usercourse = new Usercourse();
        $database = new Database();
        $database->select(new class {
            private $id;
        })
            ->from(new Usercourse())
            ->where(function() use ($id, $temp, $usercourse) {
                return $usercourse->iduser == $temp && $usercourse->idcourse == $id;
            });
        $database->execute();
        return !$database->isEmpty();
    }

    public function addToCourse(int $id, \Models\Tables\User $user)
    {

        if ($this->isSavedToCourse($id, $user)) {
            throw new \LogicException("Zostałeś zapisany wcześniej", 400);
        }

        $query = "INSERT INTO `usercourse` value('', $user->id, $id)";

        $database = new Database();
        $database->execute($query);

        return $database->checkResult();

    }
}