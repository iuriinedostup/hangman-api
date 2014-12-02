<?php

namespace Src\Library\Core\Router;

use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Exceptions\RequestException;
use Src\Library\Core\Interfaces\Router\iRoute;
use Src\Library\Core\Interfaces\Router\iRouter;
use Src\Library\Core\Registry;
use Src\Library\Core\Request\Request;

abstract class RouterAbstract implements iRouter
{
    protected $_routes = array();

    public function __construct()
    {
        $config = Registry::getInstance()->get('config');
        if (null === $config) {
            throw new ConfigException('Routers config not found');
        }
        $routerConfig = $config->get('router');

        foreach ($routerConfig as $name => $route) {
            if (!isset($route['route'], $route['APIObjectName'], $route['APIFunctionName'], $route['method'])) {
                throw new ConfigException('Wrong router config');
            }
            $this->_routes[$name] = new Route($route['route'], $route['APIObjectName'], $route['APIFunctionName'], $route['method']);
        }
    }

    /**
     * Search route by request and setup API Object and Function name if exists
     *
     * @param Request $request
     * @return mixed
     */
    function route(Request $request)
    {
        if (empty($this->_routes)) {
            return false;
        }
        $uri = trim($request->getURI(), '/');
        $partsCount = count(explode('/', $uri));
        $uriParts = explode('/', $uri);

        /**
         * @var $route iRoute - Route object
         */
        foreach ($this->_routes as $route) {
            if ($partsCount == $route->getCountRouteParts()) {
                $r = explode('/', trim($route->getRoute(), '/'));
                while ($partsCount > 0) {
                    //find params in URI and set it to request
                    if (strpos($r[$partsCount - 1], ':') !== false && preg_match('/^:([a-zA-Z\d]+)$/', $r[$partsCount-1], $match)) {
                        $request->setParam($match[1], $uriParts[$partsCount - 1]);
                    } else {
                        if ($r[$partsCount - 1] != $uriParts[$partsCount - 1]) {
                            continue 2;
                        }
                    }
                    --$partsCount;
                }
                if ($request->getMethod() !== strtoupper($route->getRequestMethod())) {
                    throw new RequestException('Incorrect request method', 405);
                }
                $request->setAPIObjectName($route->getAPIObjectName());
                $request->setAPIFunctionName($route->getAPIFunctionName());
                return $request;
            }
        }
        throw new RequestException('Requested URI is incorrect.', 405);
    }

}