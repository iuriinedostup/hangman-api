<?php
require_once './vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__);
define('APP_PATH', realpath(BASE_PATH . DS . '..' . DS . 'Src/Application'));
define('EXT','.php');

use \Src\Library\Core\FrontController;

FrontController::getInstance()->init();
FrontController::getInstance()->getBootstrap()->run();