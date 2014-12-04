<?php

namespace tests\Src\Library\Core\Request;

use Src\Library\Core\FrontController;
use Src\Library\Core\Request\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateObject()
    {
        $request = new Request();
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Request\iRequest', $request);
        return $request;
    }

    public function testParseURI()
    {
        $request = new Request('/test/act.ion/');
        $this->assertTrue('test/action' == $request->parseURI());
    }

    /**
     * @depends testCreateObject
     * @param Request $request
     */
    public function testMethod(Request $request)
    {
        $request->setMethod('GET');
        $this->assertTrue($request->getMethod() == 'GET');
        return $request;
    }

    /**
     * @depends testMethod
     * @param Request $request
     */
    public function testParams(Request $request)
    {
        $data = array('name' => 'test', 'email' => 'test@email.local');
        $request->setParams($data);
        $this->assertTrue(count($request->getParams()) == count($data));
        $this->assertTrue($request->getParam('name') == 'test');
    }

    public function testRoute()
    {
        $request = new Request('demo/index');
        $request->setMethod('GET');
        $request->processRoute(FrontController::getInstance()->getRouter());
        $this->assertTrue($request->getAPIObjectName() == 'demo');
        $this->assertTrue($request->getAPIFunctionName() == 'index');
    }
}