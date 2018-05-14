<?php

echo $this->importElement('header');
echo $this->importElement('message', 'default', $data);
echo $this->importElement('nav-bar');
echo $this->importElement('login', 'user');
echo $this->importElement('footer');