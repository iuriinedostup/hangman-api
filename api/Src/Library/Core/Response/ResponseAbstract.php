<?php

namespace Src\Library\Core\Response;

use Src\Library\Core\Exceptions\ResponseException;
use Src\Library\Core\Interfaces\Response\iResponse;

class ResponseAbstract implements iResponse
{
    const HTTP_RESPONSE_CODE_OK = 200;
    const HTTP_RESPONSE_CODE_NOT_FOUND = 404;
    const HTTP_RESPONSE_CODE_NOT_ALLOWED = 405;
    const HTTP_RESPONSE_CODE_ISE = 500;

    protected $_HTTPResponseCode;
    protected $_headers = array();
    protected $_useProvider = true;
    protected $_content;

    public function __construct()
    {
        $this->setHttpResponseCode(self::HTTP_RESPONSE_CODE_OK); //by default response is OK
    }
    /**
     * Returns HTTP response code
     *
     * @return mixed
     */
    function getHttpResponseCode()
    {
        return $this->_HTTPResponseCode;
    }

    /**
     * Set HTTP response code
     *
     * @param $code
     * @return mixed
     */
    function setHttpResponseCode($code)
    {
        if (!((int) $code) || $code < 100 || $code > 599) {
            throw new ResponseException('Invalid HTTP response code', self::HTTP_RESPONSE_CODE_ISE);
        }
        $this->_HTTPResponseCode = $code;
        return $this;
    }

    /**
     * Add header to response
     *
     * @param $name
     * @param $value
     * @param bool $replace
     * @return mixed
     */
    function addHeader($name, $value, $replace = false)
    {
        if ($replace) {
            foreach ($this->_headers as $key => $header) {
                if ($name == $header['name']) {
                    unset($this->_headers[$key]);
                }
            }
        }

        $this->_headers[] = array('name' => $name, 'value' => $value, 'replace' => $replace);
        return $this;
    }

    /**
     * Send headers
     *
     * @return mixed
     */
    function sendHeaders()
    {
        $httpCodeSent = false;
        if (headers_sent($file, $line)) {
            throw new ResponseException('Headers already sent in file ' . $file . ' line ' . $line, self::HTTP_RESPONSE_CODE_ISE);
        }
        foreach ($this->_headers as $header) {
            if (!$httpCodeSent && $this->_HTTPResponseCode) {
                header($header['name'] . ': ' . $header['value'], $header['replace'], $this->_HTTPResponseCode);
                $httpCodeSent = true;
            } else {
                header($header['name'] . ': ' . $header['value'], $header['replace']);
            }
        }

        if (!$httpCodeSent) {
            header('HTTP/1.1 ' . $this->_HTTPResponseCode);
        }

        return $this;
    }

    /**
     * Remove all headers
     *
     * @return mixed
     */
    function cleanHeaders()
    {
        $this->_headers = array();
        $this->setHttpResponseCode(self::HTTP_RESPONSE_CODE_OK);
    }

    /**
     * Flag for use or don`t use provider for response
     *
     * @param $use
     * @return mixed
     */
    function useProvider($use)
    {
        $this->_useProvider = (bool) $use;
    }

    /**
     * Prepare data and headers for response
     *
     * @return mixed
     */
    function performResponseProvider()
    {
        // TODO: Implement performResponseProvider() method.
    }

    /**
     * Set response content
     *
     * @param $content
     * @return mixed
     */
    function setContent($content)
    {
        $this->_content = $content;
        return $this;
    }

    /**
     * Returns response content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->_content;
    }


    /**
     * Send response content
     *
     * @return mixed
     */
    public function send()
    {
        $this->sendHeaders();
        echo $this->getContent() ."\n";
        exit;
    }

}