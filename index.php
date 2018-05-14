<?php

require_once 'app/init.php';
try {
    $app = new Core\App();
    $app->render();
} catch (Exception $e) {
    echo $e->getCode();
}
