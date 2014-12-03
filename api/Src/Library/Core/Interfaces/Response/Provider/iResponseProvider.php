<?php

namespace Src\Library\Core\Interfaces\Response\Provider;

use Src\Library\Core\Response\Response;

interface iResponseProvider
{
    public function __construct(Response $response);

    /**
     * Modify response content according to provider
     *
     * @return mixed
     */
    public function modify();
}