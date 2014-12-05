<?php

namespace Src\Library\Core\Response;

use Src\Library\Core\Exceptions\ResponseException;

class Response extends ResponseAbstract
{

    public function __construct()
    {
        parent::__construct();
        $this->addHeader('Content-Type', 'application/json'); //JSON by default
    }

    /**
     * Clean header and set header by default
     * @return mixed|void
     */
    public function cleanHeaders()
    {
        parent::cleanHeaders();
        $this->addHeader('Content-Type', 'application/json'); //JSON by default
    }

    /**
     * Add list of headers by one time
     *
     * @param $headers
     * @throws ResponseException
     */
    public function addHeaders($headers)
    {
        if (!empty($headers) && is_array($headers)) {
            foreach ($headers as $header) {
                if (!isset($header['name'], $header['value'], $header['replace'])) {
                    throw new ResponseException('Incorrect header.', self::HTTP_RESPONSE_CODE_ISE);
                }
                $this->addHeader($header['name'], $header['value'], $header['replace']);
            }
        }
    }
}