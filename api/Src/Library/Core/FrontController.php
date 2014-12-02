<?php

namespace Src\Library\Core;

use Src\Library\ApplicationConst;
use Src\Library\Core\Classes\Config;
use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Exceptions\RequestException;
use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Interfaces\Router\iRouter;
use Src\Library\Core\Request\Request;
use Src\Library\Core\Router\Router;

final class FrontController
{
    protected static $_instance = null;

    private $_request;
    private $_router;

    private function __construct() {}
    private function __clone() {}


    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function setRequest(iRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param mixed $router
     */
    public function setRouter(iRouter $router)
    {
        $this->_router = $router;
        return $this;
    }

    /**
     * @return iRouter
     */
    public function getRouter()
    {
        return $this->_router;
    }

    public function init()
    {
        try {
            $config = new Config(ApplicationConst::APP_CONFIG_FILE);
            Registry::getInstance()->set('config', $config);

            $router = new Router();
            $this->setRouter($router);

            $request = new Request();
            $this->setRequest($request);
        } catch (ApplicationException $e) {
            header('application-type/json');
            echo json_encode(array('error' => $e->getMessage(), 'code' => $e->getCode()));
            exit();
        }
    }
}