<?php

namespace Src\Library\Core\Router;

use Src\Library\Core\Registry;
use Src\Library\Core\Request\Request;

class Router extends RouterAbstract
{
    /**
     * Search route by request and setup API Object and Function name if exists
     *
     * @param Request $request
     * @return mixed
     */
    function route(Request $request)
    {
        return parent::route($request);
    }

}