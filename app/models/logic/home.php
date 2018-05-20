<?php

namespace Models\Logic;


use Core\Database;

class Home
{

    public function getCourse(int $id)
    {
        $database =  new Database();

        $query = "SELECT this.id, category.name, employer.nick AS employer " .
                  "FROM `course` AS this " .
                  "INNER JOIN `category` AS category ON this.idcategory = category.id " .
                  "INNER JOIN `user` as employer ON this.idemployer = employer.id " .
                  "WHERE `category`.id = $id " .
                  "GROUP  BY this.id";
        $database->execute($query);

        return $database->loadArray();
    }

    public function getCourses()
    {
        $database =  new Database();

        $query = "SELECT this.id, category.name, employer.nick AS employer " .
            "FROM `course` AS this " .
            "INNER JOIN `category` AS category ON this.idcategory = category.id " .
            "INNER JOIN `user` as employer ON this.idemployer = employer.id " .
            "GROUP  BY this.id";

        $database->execute($query);

        return $database->loadArray();
    }
}
