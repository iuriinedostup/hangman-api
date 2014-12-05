<?php

namespace tests\Src\Application\APIObjects;



use Src\Application\APIObjects\DemoAPIObject;
use Src\Library\ApplicationConst;
use Src\Library\Core\Request\Request;
use Src\Library\Core\Response\Response;

class DemoAPIObjectTest extends \PHPUnit_Framework_TestCase
{
    protected $_request;
    protected $_response;

    public function setUp()
    {
        $this->_request = new Request();
        $this->_response = new Response();
    }

    /**
     * Test instance of Demo object
     */
    public function testIndex()
    {
        $demoAPIObject = new DemoAPIObject($this->_request, $this->_response);
        $this->assertInstanceOf('Src\Library\Core\Classes\APIObject', $demoAPIObject);
    }
}