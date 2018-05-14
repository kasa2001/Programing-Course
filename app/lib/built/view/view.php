<?php

namespace Lib\Built\View;

use Lib\Built\Factory\Factory;
use Lib\Built\SEO\SEO;
use Lib\Built\URI\URI;

class View
{
    use \GetInstance;

    private static $object;
    private $config;

    /**
     * @var $seo SEO
     * */
    private $seo;

    /**
     * @var $uri URI
     * */
    private $uri;

    private function __construct($config)
    {
        $this->config = $config;
        $this->seo = Factory::getInstance("\Lib\Built\SEO\SEO", $config);
        $this->uri = Factory::getInstance("\Lib\Built\URI\URI", "");
    }

    /**
     * Method which load layout
     * @param $view - add this view
     * @param $data - current information
     * @param $css string
     * @param $js string
     * @param $seo boolean
     * */
    public function display($view, $data = [], $css = null, $js = null, $seo = true)
    {
        require_once 'app/views/layout/layout.php';
    }

    /**
     * Method add element to view
     * @param $name string - file name
     * @param $directory string - directory in folder elements (default - default)
     * @param $data \Core\Database
     * */
    public function importElement($name, $directory = "default", $data = null)
    {
        require_once "app/views/elements/" . $directory . "/" . $name . ".php";
    }

    /**
     * Method which load current view
     * @param $view string
     * @param $data array
     * @throws ViewException if file not exists
     * */
    public function content($view, $data = [])
    {
        if (file_exists('app/views/' . $view . '.php'))
            require_once 'app/views/' . $view . '.php';
        else
            throw new ViewException("Wewnętrzny błąd serwera", 500);
    }

    /**
     * Method which add CSS
     * @param $css string
     * @return string
     */
    public function loadCss($css)
    {
        $html = '';

        if ($css != "" or $css != null) {
            $table = explode(' ', $css);

            for ($i = 0; $i < (count($table)); $i++) {
                $html .= '<link rel="stylesheet" href="' . $this->config["system"]["default-directory"] . '/public/css/' . $table[$i] . '.css"  type="text/css">';
            }
        }
        return $html;
    }

    /**
     * Method which add JavaScript
     * @param $js string
     * @return string
     */
    public function loadJs($js)
    {
        $html = '';
        if ($js != "" or $js != null) {

            $table = explode(' ', $js);
            $html .= '<script src="' . (!empty($this->config["system"]["default-directory"])?$this->config["system"]["default-directory"]: '') . '/public/js/jquery-3.2.1.min.js" type="text/JavaScript"></script>';

            for ($i = 0; $i < (count($table)); $i++) {
                $html .= '<script src="' . (!empty($this->config["system"]["default-directory"])?$this->config["system"]["default-directory"]: '') . '/public/js/' . $table[$i] . '.js" type="text/JavaScript"></script>';
            }
        }
        return $html;
    }

    /**
     * Method load title page
     * @param $title string
     * @return string
     * */
    public function loadTitle($title = null)
    {
        if ($title == null) {
            return '<title>' . $this->config["system"]["default-title"] . '</title>';
        } else {
            return '<title>' . $title . '</title>';
        }


    }

    /**
     * Method load charset for page
     * */
    public function loadCharset()
    {
        return '<meta charset="' . $this->config["system"]["charset"] . '">';
    }

    /**
     * Method load language for page
     * */
    public function loadLanguage()
    {
        return 'lang="' . $this->config["system"]["default-language"] . '"';
    }

    /**
     * Method creates element a in view
     * @param $name string
     * @param $data string
     * @param $class array string (default null)
     * @param $target string
     * @param $relation string
     * @return string;
     * */
    public function buildLink($name, $data, $class = null, $target = null, $relation = null)
    {
        $html = '<a href="' . $this->uri->getBase() . (!empty($this->config["system"]["default-directory"])? '/'. $this->config["system"]["default-directory"] . '/':'/') . $data . '"';

        if (!empty($class)) {
            $html .= 'class="';

            for ($i = 0; $i < count($class); $i++) {
                $html .= $class[$i] . " ";
            }

            $html .= '"';
        }

        if ($target != null) {
            $html .= ' target=" '. $target . '"';
        }
        if ($relation != null) {
            $html .= ' relation=" '. $relation . '"';
        }
        $html .= '>' . $name . '</a>';

        return $html;
    }

    /**
     * Method open form
     * @param $action string - link to another page
     * @param $method string - method
     * @return string
     * */
    public function startForm($action = null, $method = 'post')
    {
        $html = '<form method="' . $method . '"';
        if ($action == null) {
            $html .= '>';
        } else {
            $html .= ' action="' . $this->uri->getBase() . (!empty($this->config["system"]["default-directory"])? '/' . $this->config["system"]["default-directory"] . '/':'') . $action . '">';
        }
        return $html;
    }

    /**
     * Method end form
     * */
    public function endForm()
    {
        echo '</form>';
    }

    /**
     * Method creates in page button
     * @param $text string
     * @param $class array
     * @return string
     * */
    public function button($text, $class = [])
    {
        $html = '<button ';
        if ($class != null) {
            $html .= 'class="';
            for ($i = 0; $i < count($class);
            $i++) {
                $html .= $class[$i] . " ";
            }
        }

        $html .= '>' . $text . "</button>";
        return $html;
    }

    /**
     * Method check address
     * @return string|null
     */
    public function checkAddress()
    {
        $uri = URI::getInstance();
        if ($uri->checkVars()) {
            return null;
        } else {
            return $uri->getRequestURI();
        }
    }

    /**
     * Method add mailing link
     * @param $mail string
     * @return string
     */
    public function mailingTo($mail)
    {
        return "<a href=\"mailto:" . $mail . "\">" . $mail . "</a>";
    }

    /**
     * Method wears data from database to element
     * @param $model \Core\Database
     * @param $element array string
     * @param $button boolean
     * @param $name string
     * @return string
     * */
    public function generateDynamic($model, $element = [], $button = false, $name = null)
    {
        $html = '';
        while ($result = $model->getData()) {
            if (count($element) != 1) {
                $html .= "<" . $element[0] . ">";
            }
            foreach ($result as $r) {
                if (count($element) == 1) {
                    $html .= "<" . $element . ">" . $r . "</" . $element . ">";
                } else {
                    $html .= "<" . $element[1] . ">" . $r . "</" . $element[1] . ">";
                }
            }
            if ($button) {
                $html .= "<" . $element[1] . "><button data-id = '" . $result["id"] . "'>" . $name . "</button></" . $element[1] . ">";
            }
            if (count($element) != 1) {
                $html .= "</" . $element[0] . ">";
            }
        }
        return $html;
    }

    /**
     * Method get SEO object
     * @return \Lib\Built\SEO\SEO
     * */
    public function getSEO()
    {
        return $this->seo;
    }

    /**
     * Method get data from file without loading all page
     * @param $file string
     * @param $model \Core\Database
     * */
    public function getJSON($file, $model)
    {
        require_once "app/views/api/" . $file . ".php";
    }
}
