<?php

namespace Src\Library\Core\Response\Provider;

use Src\Library\Core\Interfaces\Response\Provider\iResponseProvider;
use Src\Library\Core\Response\Response;

class JsonProvider implements iResponseProvider
{
    protected $_response;

    public function __construct(Response $response)
    {
        $this->_response = $response;
    }

    /**
     * Modify response content according to provider
     *
     * @return mixed
     */
    public function modify()
    {
        $content = $this->_response->getContent();
        if (!empty($content)) {
            $content = json_encode($content);
        }
        $this->_response->addHeader('Content-Type', 'application/json');
        $this->_response->setContent($content);
    }
}