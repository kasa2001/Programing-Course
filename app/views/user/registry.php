<?php
echo $this->importElement('header');
echo $this->importElement('message', 'default', $data);
echo $this->importElement('nav-bar');
echo $this->importElement('registry', 'user');
echo $this->importElement('footer');