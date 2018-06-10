<?php

namespace Models\Logic;


use Core\Database;
use Core\DatabaseException;
use Core\DatabaseNullException;
use Lib\Built\Security\Security;
use Models\Tables\Answer;
use Models\Tables\Category;
use Models\Tables\Useranswer;
use Models\Tables\Usercourse;
use Models\Tables\Usertype;

class User
{
    /**
     * @throws DatabaseNullException
     * @throws \ReflectionException
     * @throws DatabaseException
     * */
    public function login($name, $password)
    {
        $database = new Database();
        $user = new \Models\Tables\User();

        $database
            ->select(new class{
                private $id;
                private $nick;
                private $type;
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

    public function getReport(string $type, $date)
    {
        $type = strtoupper($type);
        $query = "SELECT this.id, employee.nick, `user`.`nick` as usnick, this.datejoin FROM  `usercourse` as this INNER JOIN `user` on `this`.`iduser` = `user`.`id` INNER JOIN course as c on this.idcourse = c.id INNER JOIN `user` as`employee` ON c.idemployer  = employee.id where $type(`this`.`datejoin`) = $date";
        $database = new Database();
        $database->execute($query);

        return $database->loadArray();

    }

    public function getUser($id)
    {
        $database = new Database();
        $user = new \Models\Tables\User();

        $database->select(new class {
            private $id;
            private $nick;
            private $type;
        })
            ->from($user)
            ->where (function() use($user, $id) {
                return $user->id == $id ;
            })
            ->execute();

        return $database->loadArray();
    }

    public function change($id, $nick, $type)
    {
        $query = "UPDATE `user` SET nick = '$nick', type = $type WHERE id = $id";

        $database = new Database();
        $database->execute($query);

        return false;
    }

    public function getParams()
    {
        $database = new Database();
        $type = new Usertype();

        $database->select($type)
            ->from($type)
            ->execute();

        return $database->loadArray();
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

    public function removeUser($id)
    {
        $user = "DELETE FROM `user` WHERE id = $id";
        $usercourse = "DELETE FROM `usercourse` where iduser = $id";
        $useranswer = "DELETE FROM `useranswer` where iduser = $id";
        $course = "DELETE FROM `course` where idemployer = $id";
        $question = "DELETE FROM `question` INNER JOIN `course` on `course`.id = `question`.idcourse WHERE course.idemployer = $id";
        $answer = "DELETE FROM `answer` INNER JOIN `question` on `answer`.idquestion = `question`.id INNER JOIN `course` on `course`.id = `question`.idcourse WHERE course.idemployer = $id";

        $database = new Database();

        $database->execute($answer);
        $database->execute($question);
        $database->execute($useranswer);
        $database->execute($usercourse);
        $database->execute($user);
        $database->execute($course);

    }

    public function addCategory(string $name)
    {
        $query = "INSERT INTO `category` VALUE(null, '$name')";
        $database = new Database();
        echo $query;
        $database->execute($query);
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


    public function getUsers()
    {
        $database = new Database();

        $database->select(new class {
            private $id;
            private $nick;
        })
            ->from(new \Models\Tables\User())
            ->execute();

        return $database->loadArray();
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

    public function isAsked(int $idcourse,\Models\Tables\User $user, int $idquestion)
    {
        $userid = $user->id;
        $useranswer = new Useranswer();
        $database = new Database();
        $database->select($useranswer)
            ->from($useranswer)
            ->where(function() use($userid, $idquestion, $idcourse, $useranswer) {
                return $useranswer->iduser == $userid && $useranswer->idquestion == $idquestion && $useranswer->idcourse == $idcourse;
            })
            ->execute();

        return !$database->isEmpty();
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

        $database = new Database();
        $database->execute($query);
    }

    public function addAnswer($id, $answer, $good)
    {
        $query = "INSERT INTO `answer` VALUE(null, '$id', '$answer', '$good')";

        $database = new Database();
        $database->execute($query);
    }

    public function addQuestion($id, $question)
    {
        $query = "INSERT INTO `question` VALUE(null, $id, '$question', NOW())";

        $database = new Database();
        $database->execute($query);
    }

    public function addCourse(\Models\Tables\User $user, $categoryid)
    {
        $query = "INSERT INTO `course` VALUE (null, '$user->id', $categoryid, NOW())";

        $database = new Database();
        $database->execute($query);
    }

}