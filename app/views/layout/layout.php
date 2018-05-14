<?php
    $seo = $this->getSEO();
?>
<!doctype html>
<html <?= $this->loadLanguage() ?>>
<head>
    <?= $seo->addBasePage(); ?>
    <?=$this->loadTitle();?>
    <?=$this->loadCharset();?>
    <?=$seo->addDescription("Strona testowa frameworka");?>
    <?=$seo->addRobotsFollow(true);?>
    <?=$seo->addCanonicalLink();?>
    <?=$seo->addLanguageLink(array("pl"));?>
    <?=$this->loadCss($css);?>
</head>
<body>
<?= $this->content($view, $data);?>
<?= $this->loadJs($js); ?>
</body>
</html>
