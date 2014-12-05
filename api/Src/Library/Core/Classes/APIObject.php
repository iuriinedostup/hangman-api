<?php

namespace Src\Library\Core\Classes;

use Src\Library\Core\Request\Request;
use Src\Library\Core\Response\Response;

abstract class APIObject
{
    protected $_request;
    protected $_response;

    public function __construct(Request $request, Response $response)
    {
        $this->setRequest($request);
        $this->getResponse($response);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->_request = $request;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->_response = $response;
    }


}