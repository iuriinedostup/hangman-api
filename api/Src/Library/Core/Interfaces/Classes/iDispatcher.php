<?php

namespace Src\Library\Core\Interfaces\Classes;

use Src\Library\Core\Interfaces\Request\iRequestParams;
use Src\Library\Core\Interfaces\Response\iResponse;

interface iDispatcher
{
    function dispatch(iRequestParams $request, iResponse $response);
    function isDispatched();
}