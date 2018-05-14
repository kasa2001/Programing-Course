<?php

require_once 'lib/built/trait/getinstance.php';
require_once 'core/autoloader.php';
$autoLoader = \Core\AutoLoader::getInstance('loadPSR4');
$autoLoader->registerNamespace('Controllers', 'app/controllers');
$autoLoader->registerNamespace('Core', 'app/core');
$autoLoader->registerNamespace('Lib', 'app/lib');
$autoLoader->registerNamespace('Models', 'app/models');
$autoLoader->registerNamespace('Modules', 'app/modules');
$autoLoader->registerNamespace('Tables', 'app/tables');
