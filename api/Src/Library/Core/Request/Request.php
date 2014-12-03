<?php

namespace Src\Library\Core\Request;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\RequestException;
use Src\Library\Core\FrontController;
use Src\Library\Core\Interfaces\Request\iRequest;
use Src\Library\Core\Interfaces\Router\iRouter;
use Src\Library\Core\Response\Response;

class Request extends RequestAbstract implements iRequest
{

    protected $_APIObjectName;
    protected $_APIFunctionName;
    protected $_method;
    protected $_params = array();

    public function __construct($uri = null)
    {
        if ($uri === null) {
            $uri = isset($_SERVER["REQUEST_URI"]) ? $uri = $_SERVER["REQUEST_URI"] : '';
        }
        $this->setURI($uri);
    }

    /**
     * Return API Object name
     *
     * @return mixed
     */
    public function getAPIObjectName()
    {
        return $this->_APIObjectName;
    }

    /**
     * Set API Object name
     *
     * @param $objectName
     * @return mixed
     */
    public function setAPIObjectName($objectName)
    {
        $this->_APIObjectName = $objectName;
        return $this;
    }

    /**
     * Return API Function name
     *
     * @return mixed
     */
    public function getAPIFunctionName()
    {
        return $this->_APIFunctionName;
    }

    /**
     * Set API function Name
     *
     * @param $functionName
     * @return mixed
     */
    public function setAPIFunctionName($functionName)
    {
        $this->_APIFunctionName = $functionName;
        return $this;
    }

    /**
     * Parse request URL and conversion of it
     *
     * @return mixed
     */
    public function parseURI()
    {
        $uri = $this->getURI() !== null ? $this->getURI() : '';
        $path = trim(parse_url($uri, PHP_URL_PATH), "/");
        $path = preg_replace('/[^a-zA-Z0-9\/]/', "", $path);
        return $path;
    }

    /**
     * Return request method
     *
     * @return mixed
     */
    public function getMethod()
    {
        if (null !== $this->_method) {
            return $this->_method;
        }
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $methods = array(
            ApplicationConst::REQUEST_METHOD_GET,
            ApplicationConst::REQUEST_METHOD_POST,
            ApplicationConst::REQUEST_METHOD_PUT,
            ApplicationConst::REQUEST_METHOD_DELETE
        );
        if (empty($method) || !in_array($method, $methods)) {
            throw new RequestException('Wrong request method.', Response::HTTP_RESPONSE_CODE_ISE);
        }
        $this->_method = $method;
        return $this->_method;
    }

    /**
     * Set request params array
     *
     * @param $params
     * @return mixed
     */
    function setParams($params)
    {
        if (!empty($params) && is_array($params)) {
            foreach ($params as $key=>$value) {
                $this->setParam($key, $value);
            }
        }
    }

    /**
     * Returns request params
     *
     * @return mixed
     */
    function getParams()
    {
        return $this->_params;
    }

    /**
     * Set request parameter by $key
     *
     * @param $key
     * @param $param
     * @return mixed
     */
    function setParam($key, $param)
    {
        $this->_params[$key] = $param;
        return $this;
    }

    /**
     * Return request param by key
     *
     * @param $key
     * @return mixed
     */
    function getParam($key, $default = null)
    {
        if (isset($this->_params[$key])) {
            return $this->_params[$key];
        } elseif (isset($_GET[$key])) {
            return $_GET[$key];
        } elseif (isset($_POST[$key])) {
            return $_POST[$key];
        } elseif (isset($_REQUEST[$key])) {
            return $_REQUEST[$key];
        } else {
            return $default;
        }
    }


    /**
     * Find requested URI in routes and check method
     *
     * @return mixed
     */
    public function processRoute(iRouter $router)
    {
        $this->setURI($this->parseURI());
        $router->route($this);
    }


}