<?php

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv(
    'APPLICATION_ENV'
) : 'production'));

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__);
define('APP_PATH', realpath(BASE_PATH . DS . '..' . DS . 'Src/Application'));
define('EXT','.php');

if (is_readable('../autoloader.php')) {
    require_once '../autoloader.php';
}

use Src\Library\Core\FrontController;

FrontController::getInstance()->init()->run();