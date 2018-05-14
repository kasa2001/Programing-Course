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

//    Example structured data
//
//
//    {
//        "@context": "http://schema.org/",
//        "@type": "NewsArticle",
//        "name": "Wokalista Avenged Sevenfold: Linkin Park powinien grać dalej bez Chestera",
//        "headline": "M. Shadows uważa, że Mike Shinoda jako prawdziwy lider powinien dalej prowadzić Linkin Park po tragicz...",
//        "mainEntityOfPage":{
//            "@type":"WebPage",
//                "@id":"http://www.antyradio.pl/Muzyka/Rock-News"
//            },
//        "image": {
//            "@type": "ImageObject",
//            "url": "http://www.antyradio.pl/var/antyradio/storage/images/muzyka/rock-news/wokalista-avenged-sevenfold-linkin-park-powinien-grac-dalej-bez-chestera-18648/1312461-1-pol-PL/Wokalista-Avenged-Sevenfold-Linkin-Park-powinien-grac-dalej-bez-Chestera_article.jpg",
//            "height": 640,
//            "width": 982
//        },
//        "author": "Antyradio",
//        "publisher": {
//            "@type": "Organization",
//            "name": "Eurozet Sp. z o.o.",
//            "logo": {
//                "@type": "ImageObject",
//                "url": "http://gfx.antyradio.pl/design/antyradio_2015/images/layout/logo.png"
//            }
//        },
//        "datePublished": "2017-11-22T04:08:01 +0100",
//        "dateModified": "2017-11-22T16:12:27 +0100",
//        "description": "M. Shadows uważa, że Mike Shinoda jako prawdziwy lider powinien dalej prowadzić Linkin Park po tragicznej śmierci Chestera Benningtona.",
//        "articleBody": "20 lipca 2017 był czarnym dniem dla fanów Linkin Park. Jego wokalista, Chester Bennington popełnił wtedy samobójstwo przez powieszenie. Wielbiciele artysty na całym świecie składali mu wzruszające hołdy – z pewnością dla wielu z nich tragedia oznaczała koniec ukochanego zespołu.Przez kilka dni po śmierci wokalisty pozostali członkowie Linkin Park powstrzymywali się od oficjalnego komentarza ze strony zespołu. Wreszcie 24 lipca 2017 opublikowali list pożegnalny do zmarłego kolegi, w którym napisali:Nasza miłość do pisania i wykonywania muzyki jest nie do opisania. Nie wiemy jeszcze, jak będzie wyglądała nasza przyszłość bez ciebie, ale wiemy, że nasze życia stały się lepsze dzięki tobie.Sprawa dalszego funkcjonowania zespołu pozostawała więc otwarta. 27 października 2017 w Los Angeles odbył się wielki koncert pamięci Chestera, na którym u boku muzyków Linkin Park wystąpiły inne gwiazdy rocka, m.in. Oli Sykes z Bring Me The Horizon. W jego trakcie drugi wokalista grupy, Mike Shinoda zaśpiewał zupełnie nowy utwór, „Looking For An Answer”. Był to pierwszy występ „Linkinów” od ostatniego koncertu z Benningtonem, 6 lipca 2017 w Birmingham.Członkowie Linkin Park wrócili na scenę, tworzą nowe kompozycje – czy to znaczy, że jednak będą działać bez Chestera? Wśród fanów i ludzi z branży muzycznej toczą się dyskusje na ten temat. Ostatnio głos zabrał M. Shadows, wokalista Avenged Sevenfold, dobry przyjaciel Mike’a Shinody. Uważa, że Mike powinien przejąć obowiązki lidera i działać z kolegami dalej.Shadows mówił w wywiadzie dla Eddiego Trunka:Nie znałem zbyt dobrze Chestera, raczej przelotnie. Ale mocno się przyjaźnię z Mike’em Shinodą i Dave’em Farrellem.Strata Chestera musi być dla nich ogromna – z pewnością był jednym z najlepszych wokalistów naszych czasów. Chodziłem na ich koncerty, kiedy dorastałem. Był doskonały w tym, co robił. Ale równocześnie Mike tak ciężko pracował i był tak oddany zespołowi, włożył w niego tak wiele czasu, że nie wyobrażam sobie, by po prostu dał sobie z nim spokój.[Linkin Park] są ludźmi i mają przed sobą długie życie. Myślę, że jeśli kochają muzykę tak bardzo, to mają pełne prawo iść naprzód. Znam bardzo dobrze Mike’a i w mojej opinii on zawsze był liderem zespołu – gościem, który go napędzał, który robił demówki, który miał obsesyjne podejście do każdego szczegółu związanego z zespołem.To byłby po prostu wstyd, gdyby przestali robić razem muzykę. Nie wiem, czy zrobią to pod nazwą Linkin Park, czy pod inną. Ale Mike jest kreatywną siłą tego zespołu.M. Shadows jest kompetentną osobą do dyskusji na ten temat, ponieważ jego Avenged Sevenfold także musiał zmierzyć się ze stratą jednego z członków. W 2009 roku z powodu przedawkowania narkotyków zmarł perkusista zespołu, James Sullivan, znany jako The Rev. Zespół otrząsnął się po tej tragedii i radzi sobie na tyle dobrze, że gitarzysta Zacky Vengeance porównuje go do Metalliki i Iron Maiden."
//    }
