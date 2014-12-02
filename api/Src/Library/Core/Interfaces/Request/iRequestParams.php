<?php

namespace Src\Library\Core\Interfaces\Request;

interface iRequestParams
{

    /**
     * Return API Object name
     *
     * @return mixed
     */
    function getAPIObjectName();

    /**
     * Set API Object name
     *
     * @param $objectName
     * @return mixed
     */
    function setAPIObjectName($objectName);

    /**
     * Return API Function name
     *
     * @return mixed
     */
    function getAPIFunctionName();

    /**
     * Set API function Name
     *
     * @param $functionName
     * @return mixed
     */
    function setAPIFunctionName($functionName);

    /**
     * Set request params array
     *
     * @param $params
     * @return mixed
     */
    function setParams($params);

    /**
     * Returns request params
     *
     * @return mixed
     */
    function getParams();

    /**
     * Set request parameter by $key
     *
     * @param $key
     * @param $param
     * @return mixed
     */
    function setParam($key, $param);

    /**
     * Return request param by key
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    function getParam($key, $default);
}