<?php

namespace Src\Library\Core\Interfaces\Response;

interface iResponse
{
    /**
     * Returns HTTP response code
     *
     * @return mixed
     */
    function getHttpResponseCode();

    /**
     * Set HTTP response code
     *
     * @param $code
     * @return mixed
     */
    function setHttpResponseCode($code);

    /**
     * Add header to response
     *
     * @param $name
     * @param $value
     * @param bool $replace
     * @return mixed
     */
    function addHeader($name, $value, $replace = false);

    /**
     * Send headers
     *
     * @return mixed
     */
    function sendHeaders();

    /**
     * Remove all headers
     *
     * @return mixed
     */
    function cleanHeaders();

    /**
     * Flag for use or don`t use provider for response
     *
     * @param $use
     * @return mixed
     */
    function useProvider($use);

    /**
     * Prepare data and headers for response
     *
     * @return mixed
     */
    function performResponseProvider();

    /**
     * Set response content
     *
     * @param $content
     * @return mixed
     */
    function setContent($content);

    /**
     * Returns response content
     *
     * @return mixed
     */
    function getContent();

    /**
     * Send response headers and content
     *
     * @return mixed
     */
    function send();
}