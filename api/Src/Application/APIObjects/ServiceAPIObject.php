<?php

namespace Src\Application\APIObjects;

use Src\Application\Models\Word;
use Src\Library\Core\Classes\APIObject;
use Src\Library\Core\Registry;

class ServiceAPIObject extends APIObject
{
    public function loadFunction()
    {
        $service = Registry::getInstance()->get('config')->get('service');
        if (empty($service)) {
            return array('result' => 'error', 'message' => 'Service config not found');
        }
        $key = $this->getRequest()->getParam('key', false);
        if ($key != $service['key']) {
            return array('result' => 'error', 'message' => 'Service key is incorrect');
        }
        $result = array('result' => 'ok');
        $file = $service['wordsFile'];
        if (is_readable($file)) {
            $f = fopen($file, 'r');
            $word = new Word();
            $n = $word->loadWords($f);
            $result['message'] = 'Inserted rows: ' . $n;
        } else {
            $result['result'] = 'error';
            $result['message'] = 'Unable to read words file.';
        }
        return $result;
    }
}