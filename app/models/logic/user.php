<?php

namespace Models\Logic;


use Core\Database;
use Core\DatabaseNullException;
use Lib\Built\Security\Security;
use Models\Tables\Answer;
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

    public function getUserCourse(\Models\Tables\User $user)
    {
        $query = "SELECT `this`.`name`, `course`.`id`, `uscourse`.`datejoin` FROM `category` as `this` INNER JOIN `course` AS `course` ON `this`.`id` = `course`.`idcategory` INNER JOIN `usercourse` AS `uscourse` ON `course`.`id` = `uscourse`.`idcourse` WHERE `uscourse`.`iduser` = $user->id";

        $database = new Database();
        $database->execute($query);
        return $database->loadArray();
    }

    public function getAnswers($id)
    {
        $answer = new Answer();
        $database = new Database();
        $database->select($answer)
            ->from($answer)
            ->where(function() use ($answer, $id) {
                return $answer->idquestion == $id;
            })
            ->execute();
        if ($database->countRecords() > 1)
            return $database->loadArray();
        else if ($database->countRecords() == 1){
            $data = [
                $database->loadArray()
            ];
            return $data;
        } else {
            return false;
        }
    }

    /**
     * @throws DatabaseNullException
     * */
    public function getQuestion($id, $limit)
    {
        $query = "SELECT `id`, `quest` FROM `question` WHERE `idcourse` = $id LIMIT $limit,1";

        $database = new Database();
        $database->execute($query);
        $question = $database->loadArray();
        $data = [
            'question' => $question,
            'answers' => $this->getAnswers($question['id']),
            'next' => ++$limit,
            'courseid' => $id
        ];
        return $data;
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

        $query = "INSERT INTO `usercourse` value('', $user->id, $id, NOW(), null)";

        $database = new Database();
        $database->execute($query);

        return $database->checkResult();

    }

    public function saveAnswer(int $idcourse, int $idquestion, $answer, \Models\Tables\User $user)
    {
        if (is_numeric($answer)) {
            $query = "INSERT INTO `useranswer` (`idcourse`, `idquestion`, `idanswer`, `iduser`) VALUE($idcourse, $idquestion, $answer, $user->id)";
        } else {
            $answer = Security::slashSQLString($answer);
            $query = "INSERT INTO `useranswer` (`idcourse`, `idquestion`, `code`, `iduser`) VALUE($idcourse, $idquestion, '$answer', $user->id)";
        }
        echo $query;
        $database = new Database();
        $database->execute($query);
    }

    public function addQuestion($id)
    {
        $query = "INSERT INTO `question` VALUE()";
    }
}