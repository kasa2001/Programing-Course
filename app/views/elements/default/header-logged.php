<header class="head">
    <div class="button">
        <?=$this->buildLink("Wyloguj się", "user/logout")?>
        <?=$this->buildLink('Lista Twoich kursów', 'user/listing')?>
        <?=$this->buildLink('Strona z moźliwymi specjalizacjami', 'home/index') ?>
        <?=$this->buildLink('Raport z maja', 'user/renderreport/month/5') ?>
        <?=$this->buildLink('Lista użytkowników', 'user/listOfUsers') ?>
    </div>
</header>