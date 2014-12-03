<?php

namespace Src\Application\APIObjects;

use Src\Library\Core\Classes\APIObject;
use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Response\Response;

class DemoAPIObject extends APIObject
{
    public function indexFunction()
    {
        return array('result' => 'ok');
    }
}