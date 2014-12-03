<?php

namespace Src\Library\Core\Request;

use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Interfaces\Request\iRequestParams;

abstract class RequestAbstract implements iRequest, iRequestParams
{
    protected $_uri;
    /**
     * Return requested URI
     *
     * @return mixed
     */
    public function getURI()
    {
        return $this->_uri;
    }

    /**
     * Set requested URI
     *
     * @param $uri
     * @return mixed
     */
    protected function setURI($uri)
    {
        $this->_uri = $uri;
        return $this;
    }
}