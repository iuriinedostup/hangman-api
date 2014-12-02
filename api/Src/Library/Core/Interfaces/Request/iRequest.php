<?php

namespace Src\Library\Core\Interfaces\Request;

use Src\Library\Core\Interfaces\Router\iRouter;

interface iRequest
{
    /**
     * Parse request URL and conversion of it
     *
     * @return mixed
     */
    function parseURI();

    /**
     * Return request method
     *
     * @return mixed
     */
    function getMethod();

    /**
     * Find requested URI in routes and check method
     *
     * @return mixed
     */
    function processRoute(iRouter $router);
}