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
}