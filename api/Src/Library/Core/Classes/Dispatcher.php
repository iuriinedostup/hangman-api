<?php

namespace Src\Library\Core\Classes;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Interfaces\Classes\iDispatcher;
use Src\Library\Core\Interfaces\Request\iRequestParams;
use Src\Library\Core\Interfaces\Response\iResponse;
use Src\Library\Core\Response\Response;

final class Dispatcher implements iDispatcher
{
    private $_isDispatched;

    public function __construct()
    {
        $this->setIsDispatched(false);
    }

    public function dispatch(iRequestParams $request, iResponse $response)
    {
        $APIObjectName = ucfirst(strtolower($request->getAPIObjectName())) . 'APIObject';
        $APIFunctionName = strtolower($request->getAPIFunctionName()) . 'Function';
        $APIObjectClass = ApplicationConst::APIObjectNS . $APIObjectName;
        if (!class_exists($APIObjectClass)) {
            throw new ApplicationException('APIObject is not exists.', Response::HTTP_RESPONSE_CODE_ISE);
        }
        if (method_exists($APIObjectClass, $APIFunctionName)) {
            try {
                $APIObject = new $APIObjectClass($request, $response);
                $result = $APIObject->$APIFunctionName();
                $response->setContent($result);
            } catch (ApplicationException $e)
            {
                $response->cleanHeaders();
                $response->setHttpResponseCode($e->getCode());
                $response->setContent(json_encode(array('error' => $e->getMessage())));
            }
        }

    }

    public function isDispatched()
    {
        return (bool) $this->getIsDispatched();
    }

    /**
     * @return mixed
     */
    public function getIsDispatched()
    {
        return $this->_isDispatched;
    }

    /**
     * @param mixed $isDispatched
     */
    public function setIsDispatched($isDispatched)
    {
        $this->_isDispatched = $isDispatched;
    }



}