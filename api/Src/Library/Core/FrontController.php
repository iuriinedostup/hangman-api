<?php

namespace Src\Library\Core;

use Src\Library\ApplicationConst;

final class FrontController
{
    protected static $_instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function init()
    {
        $config = new Config(ApplicationConst::APP_CONFIG_FILE);
        Registry::getInstance()->set('config', $config);
    }
}