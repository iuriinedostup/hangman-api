<?php

namespace tests\Src\Library\Core\Response;

use Src\Library\Core\Exceptions\ResponseException;
use Src\Library\Core\Response\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateObject()
    {
        $response = new Response();
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Response\iResponse', $response);
        return $response;
    }

    /**
     * @depends testCreateObject
     * @param Response $response
     */
    public function testHTTPCode(Response $response)
    {
        $this->assertEquals(200, $response->getHttpResponseCode());
    }

    /**
     *
     * @depends testCreateObject
     * @param Response $response
     */
    public function testExceptionForHTTPCode(Response $response)
    {
        $httpCode = $response->getHttpResponseCode();
        try {
            $response->setHttpResponseCode(0);
        } catch (ResponseException $e)
        {
            $httpCode = $e->getCode();
        }
        $this->assertEquals($httpCode, 500);
    }
}