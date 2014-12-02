<?php

namespace Src\Library\Core\Interfaces\Router;

use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Interfaces\Request\iRequestParams;
use Src\Library\Core\Request\Request;

interface iRouter
{
    /**
     * Search route by request and setup API Object and Function name if exists
     *
     * @param Request $request
     * @return mixed
     */
    function route(Request $request);
}