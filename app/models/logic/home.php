<?php

namespace Models\Logic;


use Core\Database;

class Home
{

    /**
     * @param $id int
     * @return array
     * @throws \Core\DatabaseNullException
     * */
    public function getCourse(int $id): array
    {
        $database =  new Database();

        $query = "SELECT this.id, category.name, employer.nick AS employer " .
                  "FROM `course` AS this " .
                  "INNER JOIN `category` AS category ON this.idcategory = category.id " .
                  "INNER JOIN `user` as employer ON this.idemployer = employer.id " .
                  "WHERE `category`.id = $id " .
                  "GROUP  BY this.id " .
                  "ORDER BY this.id ASC";
        $database->execute($query);

        return $database->loadArray();
    }

    public function getCourses() : array
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
