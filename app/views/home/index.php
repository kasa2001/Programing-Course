<?php
if ($data['user'])
    $this->importElement('header-logged', 'default', $data);
else
    $this->importElement('header');
$this->importElement("nav-bar");
$this->importElement("hello", "home",  $data);
$this->importElement("footer");
