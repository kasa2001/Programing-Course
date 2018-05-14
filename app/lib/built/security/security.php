<?php

namespace Lib\Built\Security;

class Security
{
    /**
     * Method check string and add slashes
     * @param $data string
     * @return string/null
     * */
    public static function slashSQLString($data)
    {
        return addslashes($data);
    }

    /**
     * Method check string and add slashes
     * @param $data array
     * @return array
     * */
    public static function slashSQLForm($data)
    {
        foreach ($data as $key => $datum) {
            $data[$key] = addslashes($datum);
        }
        return $data;
    }

    /**
     * Method check integer to SQL query
     * @param $data array
     * @return boolean
     * */
    public static function checkNumber($data)
    {
        foreach ($data as $datum) {
            if (!is_numeric($datum)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Method save data about attack on page
     * @param $attack string
     * */
    public static function addLog($attack)
    {
        $file = ("../app/logs/" . $attack . ".log");
        $FILE = fopen($file, "a");
        fwrite($FILE, "Atak z dnia: " . date("d/m/y") . " godziny: " . date("h:i:sa") . "\n");
        fclose($FILE);
    }

    /**
     * Method check data from form and add html special chars.
     * @param $data array
     * @return array
     * */
    public static function analyzeXSS($data)
    {
        foreach ($data as $key => $datum) {
            $data[$key] = htmlspecialchars($datum);
        }
        return $data;
    }
}
