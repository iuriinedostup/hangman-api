<?php

namespace Src\Library\Core;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\ConfigException;

class Config
{
    protected $_fileName;

    public function __construct($filename, $path = '')
    {
        if (!is_string($filename) || empty($filename)) {
            throw new ConfigException('Wrong config file name', 500);
        }
        if (empty($path)) {
            $path = APP_PATH . DS . ApplicationConst::APP_CONFIG_DIR . DS;
        }
        $configFile = $path . $filename;
        if (!is_readable($configFile)) {
            throw new ConfigException('Config file not found', 500);
        }
        $this->_fileName = $filename;
    }
}