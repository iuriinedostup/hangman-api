<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . DS . 'Src/Application');
define('EXT','.php');

if (is_readable('autoloader.php')) {
    require_once 'autoloader.php';
}

use Src\Library\Core\FrontController;

FrontController::getInstance()->init();