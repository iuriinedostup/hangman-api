<?php

namespace Src\Library\Core;

use Src\Library\Core\Request\Request;
use Src\Library\Core\Response\Response;

abstract class BootstrapAbstract
{
    protected $_request;
    protected $_response;

    final public function __construct(Request $request, Response $response)
    {
        $this->_request = $request;
        $this->_response = $response;
    }

    /**
     * Parse _init methods and run
     */
    final public function run()
    {
        $methods = get_class_methods($this);
        foreach ($methods as $method) {
            if (preg_match('/^_init\D+/', $method, $match)) {
                call_user_func(array($this, $method));
            }
        }
    }
}