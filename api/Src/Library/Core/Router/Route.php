<?php

namespace Src\Library\Core\Router;

use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Interfaces\Router\iRoute;

class Route implements iRoute
{

    protected $_route;
    protected $_APIObjectName;
    protected $_APIFunctionName;
    protected $_method;
    protected $_countRouteParts;

    public function __construct($route, $APIObjectName, $APIFunctionName, $method)
    {
        //validate route, controller and action names
        array_map(function($value){
                if (empty($value) || !preg_match('/^[a-zA-Z_\/\d:]+$/', $value)) {
                    throw new ConfigException('Invalid route params.');
                }
            }, array($route, $APIObjectName, $APIFunctionName, $method));

        $this->setRoute($route);
        $this->setAPIObjectName($APIObjectName);
        $this->setAPIFunctionName($APIFunctionName);
        $this->setRequestMethod($method);
        $this->setCountRouteParts(count(explode('/', trim($route, '/'))));
    }

    /**
     * Returns route
     *
     * @return mixed
     */
    function getRoute()
    {
        return $this->_route;
    }

    /**
     * Set route
     *
     * @param $route
     * @return mixed
     */
    function setRoute($route)
    {
        $this->_route = $route;
        return $this;
    }

    /**
     * Returns route APIObject name
     *
     * @return mixed
     */
    function getAPIObjectName()
    {
        return $this->_APIObjectName;
    }

    /**
     * Set APIObject name
     *
     * @param $objectName
     * @return mixed
     */
    function setAPIObjectName($objectName)
    {
        $this->_APIObjectName = $objectName;
        return $this;
    }

    /**
     * Returns API Object function name
     *
     * @return mixed
     */
    function getAPIFunctionName()
    {
        return $this->_APIFunctionName;
    }

    /**
     * Set APIObject function name
     *
     * @param $functionName
     * @return mixed
     */
    function setAPIFunctionName($functionName)
    {
        $this->_APIFunctionName = $functionName;
        return $this;
    }

    /**
     * Returns route request method
     *
     * @return mixed
     */
    function getRequestMethod()
    {
        return $this->_method;
    }

    /**
     * Set route request method
     *
     * @param $method
     * @return mixed
     */
    function setRequestMethod($method)
    {
        $this->_method = $method;
        return $this;
    }

    /**
     * @param $count
     * @return mixed|void
     */
    public function setCountRouteParts($count)
    {
        $this->_countRouteParts = $count;
    }

    /**
     * @return mixed
     */
    public function getCountRouteParts()
    {
        return $this->_countRouteParts;
    }

}