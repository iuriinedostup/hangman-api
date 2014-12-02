<?php

namespace Src\Library\Core;

use Src\Library\ApplicationConst;
use Src\Library\Core\Classes\Config;
use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Request\Request;

final class FrontController
{
    protected static $_instance = null;

    private $_request;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setRequest(iRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    public function init()
    {
        $config = new Config(ApplicationConst::APP_CONFIG_FILE);
        Registry::getInstance()->set('config', $config);

        $request = new Request();
        $this->setRequest($request);
    }
}