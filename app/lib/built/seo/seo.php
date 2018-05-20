<?php

namespace Lib\Built\SEO;

use Lib\Built\Factory\Factory;

class SEO
{
    private static $object;
    private $uri;
    private $h1 = false;

    use \GetInstance;

    private function __construct($config)
    {
        $this->uri = Factory::getInstance("\Lib\Built\URI\URI", $config);
    }

    /**
     * Method add to head canonical link. Use one link for page.
     * */
    public function addCanonicalLink()
    {
        echo "<link rel=\"canonical\" href= \"" . $this->uri->getBase() . $_SERVER["REQUEST_URI"] . "\">";
    }

    /**
     * Method add base page to head. Use one link for page
     * */
    public function addBasePage()
    {
        echo "<base href= \"" . $this->uri->getBase(). "\">";
    }

    /**
     * Method add alternate link for mobile. Use when you got page for mobile view
     * todo (this method is incomplete)
     */
    public function addMobileLink()
    {
        echo "<link rel=\"alternate\" media=\"only screen and (max-width: 640px)\" href=\"\">";
    }

    /**
     * Method add meta tag for mobile view init. Use only, when you have responsive page
     * */
    public function addViewport()
    {
        echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
    }

    /**
     * Method add description page. Use one link for page
     * @param  $data string
     */
    public function addDescription($data)
    {
        echo "<meta name=\"description\" content=\"" . $data . "\">";
    }

    /**
     * Method add languages page
     * @param  $lang array
     */
    public function addLanguageLink($lang)
    {
        foreach ($lang as $l) {
            echo "<link rel=\"alternate\" hreflang=\"" . $l ."\" href=\"" . $this->uri->getAddress() ."\">";
        }
    }

    /**
     * Method add metadata for search bots. Use one link for page
     * @param $agree boolean
     * */
    public function addRobotsFollow($agree)
    {
        if ($agree) {
            echo "<meta name=\"robots\" content=\"index,follow\">";
        } else {
            echo "<meta name=\"robots\" content=\"none\">";
        }
    }

    /**
     * Method add h1 element to page.
     * @param $words string
     * @param $class array default null
     * */
    public function addKeyWords($words, $class = null)
    {
        try {
            if ($this->h1) {
                throw new SEOException("Element h1 can be use only one time");
            }
        } catch (SEOException $e) {

        }
        echo "<h1";
        if ($class!==null) {
            echo" class = \"";
            foreach ($class as $item) {
                echo $item . " ";
            }
            echo "\"";
        }
        echo ">" . $words ."</h1>";

        $this->h1 = true;
    }

    public function addHttpEquiv($charset)
    {
        echo '<meta http-equiv="content-type" content="text/html; charset=' . $charset . '">';
    }

    public function addStructuralData($json)
    {
        echo '<script type="application/ld+json">' . $json . '</script>';
    }

    public function addShortLink($link)
    {

    }
}
