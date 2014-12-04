<?php

namespace tests\Src\Library\Core\Route;

use Src\Library\Core\Router\Route;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRoute()
    {
        $route = new Route('test/manage', 'testObject', 'testManage', 'POST');
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Router\iRoute', $route);
        return $route;
    }

    /**
     * @depends testCreateRoute
     * @param Route $route
     */
    public function testRouteParams(Route $route)
    {
        $this->assertEquals($route->getRoute(), 'test/manage');
        $this->assertEquals($route->getAPIObjectName(), 'testObject');
        $this->assertEquals($route->getAPIFunctionName(), 'testManage');
        $this->assertEquals($route->getRequestMethod(), 'POST');
        $this->assertEquals($route->getCountRouteParts(), 2);

    }
}