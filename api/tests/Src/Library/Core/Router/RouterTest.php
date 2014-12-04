<?php

namespace tests\Src\Library\Core\Route;

use Src\Library\Core\Request\Request;
use Src\Library\Core\Router\Router;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    protected $_router;

    public function setUp()
    {
        $this->_router = new Router();
    }

    public function testRouter()
    {
        $request = new Request('demo/index');
        $request->setMethod('GET');
        $this->_router->route($request);
        $this->assertEquals($request->getAPIObjectName(), 'demo');
        $this->assertEquals($request->getAPIFunctionName(), 'index');
        $this->assertEquals($request->getMethod(), 'GET');
    }
}