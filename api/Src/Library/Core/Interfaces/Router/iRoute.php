<?php

namespace Src\Library\Core\Interfaces\Router;

interface iRoute
{

    /**
     * Returns route
     *
     * @return mixed
     */
    function getRoute();

    /**
     * Set route
     *
     * @param $route
     * @return mixed
     */
    function setRoute($route);

    /**
     * Returns route APIObject name
     *
     * @return mixed
     */
    function getAPIObjectName();

    /**
     * Set APIObject name
     *
     * @param $objectName
     * @return mixed
     */
    function setAPIObjectName($objectName);

    /**
     * Returns API Object function name
     *
     * @return mixed
     */
    function getAPIFunctionName();

    /**
     * Set APIObject function name
     *
     * @param $functionName
     * @return mixed
     */
    function setAPIFunctionName($functionName);

    /**
     * Returns route request method
     *
     * @return mixed
     */
    function getRequestMethod();

    /**
     * Set route request method
     *
     * @param $method
     * @return mixed
     */
    function setRequestMethod($method);

    /**
     * Returns count of route parts
     *
     * @return mixed
     */
    function getCountRouteParts();

    /**
     * Set count of route parts
     *
     * @param $count
     * @return mixed
     */
    function setCountRouteParts($count);
}