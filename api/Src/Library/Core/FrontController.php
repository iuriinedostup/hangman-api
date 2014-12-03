<?php

namespace Src\Library\Core;

use Src\Library\ApplicationConst;
use Src\Library\Core\Classes\Config;
use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Exceptions\RequestException;
use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Interfaces\Response\iResponse;
use Src\Library\Core\Interfaces\Router\iRouter;
use Src\Library\Core\Request\Request;
use Src\Library\Core\Response\Response;
use Src\Library\Core\Router\Router;

final class FrontController
{
    protected static $_instance = null;

    private $_request;
    private $_response;
    private $_router;

    private function __construct() {}
    private function __clone() {}

    /**
     * Returns instance of FrontController object
     *
     * @return null|FrontController
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Set Request to object params
     *
     * @param iRequest $request
     * @return $this
     */
    public function setRequest(iRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Returns request object
     *
     * @return mixed
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @return iResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param iResponse $response
     */
    public function setResponse(iResponse $response)
    {
        $this->_response = $response;
    }

    /**
     * Set router object
     *
     * @param iRouter $router
     * @return FrontController
     */
    public function setRouter(iRouter $router)
    {
        $this->_router = $router;
        return $this;
    }

    /**
     * Returns router object
     *
     * @return iRouter
     */
    public function getRouter()
    {
        return $this->_router;
    }

    /**
     * Init application resources
     */
    public function init()
    {
        try {
            $response = new Response();
            $this->setResponse($response);

            $config = new Config(ApplicationConst::APP_CONFIG_FILE);
            Registry::getInstance()->set('config', $config);

            $router = new Router();
            $this->setRouter($router);

            $request = new Request();
            $this->setRequest($request);


        } catch (ApplicationException $e) {
            if ($this->getResponse()) {
                $this->getResponse()->addHeader('Content-Type', 'application-type/json');
                $this->getResponse()->setContent(json_encode(array('error' => $e->getMessage(), 'code' => $e->getCode())));
                $this->getResponse()->send();
            } else {
                header('application-type/json');
                echo json_encode(array('error' => $e->getMessage(), 'code' => $e->getCode()));
                exit();
            }
        }
    }
}