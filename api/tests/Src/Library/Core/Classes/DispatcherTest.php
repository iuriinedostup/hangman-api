<?php

namespace tests\Src\Library\Core\Classes;

use Src\Library\Core\Classes\Dispatcher;
use Src\Library\Core\Request\Request;
use Src\Library\Core\Response\Response;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    protected $_request;
    protected $_response;

    public function setUp()
    {
        $request = new Request();
        $request->setAPIObjectName('Demo');
        $request->setAPIFunctionName('index');
        $request->setMethod('GET');
        $response = new Response();
        $this->_request = $request;
        $this->_response = $response;
    }

    public function testCreateDispatcher()
    {
        $dispatcher = new Dispatcher();
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Classes\iDispatcher', $dispatcher);
        return $dispatcher;
    }

    /**
     * @depends testCreateDispatcher
     * @param $dispatcher Dispatcher
     */
    public function testDispatch($dispatcher)
    {
        $this->assertTrue($dispatcher->isDispatched() == false);
        $dispatcher->dispatch($this->_request, $this->_response);
        $this->assertNotEmpty($this->_response->getContent(), 'Response are empty.');
        $dispatcher->setIsDispatched(true);
        $this->assertTrue($dispatcher->isDispatched() == true);

    }
}