<?php

namespace Src\Library\Core\Classes;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Interfaces\Classes\iConfig;
use Src\Library\Core\Response\Response;

class Config implements iConfig
{
    protected $_fileName;
    protected $_data = array();

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
        $this->_fileName = $configFile;
        $this->_load();
    }

    /**
     * Load and parse config file
     *
     * @return mixed
     */
    function _load()
    {
        $config = parse_ini_file($this->_fileName, true);
        $data = array();
        foreach ($config as $key=>$conf)
        {
            if (preg_match("/^" . APPLICATION_ENV . ":/", $key)) {
                $data = $conf;
                $parts = explode(':', $key);
                $parent = trim($parts[1]);
                break;
            }
        }
        if (!(empty($data)) && isset($parent)) {
            $data = array_merge($config[$parent], $data);
        } elseif(isset($config[APPLICATION_ENV])) {
            $data = $config[APPLICATION_ENV];
        }else {
            throw new ConfigException('Incorrect config.', Response::HTTP_RESPONSE_CODE_ISE);
        }
        if (empty($data)) {
            return $this;
        }
        foreach ($data as $key=>$value) {
            if (!(preg_match('/^[\da-zA-Z_\.]+$/', $key))) {
                throw new ConfigException('Invalid config key.');
            }
            if (strpos($key, '.') === false) {
                $this->_data[$key] = $value;
            } else {
                //parse dots as array keys
                $keys = array_reverse(explode(".", $key));
                $item = array();
                $item[array_shift($keys)] = $value;
                $buf = $item;
                while (count($keys) > 0) {
                    $k = array_shift($keys);
                    $item = array();
                    $item[$k] = $buf;
                    $buf = $item;
                }
                $this->_data = array_merge_recursive($this->_data, $item);
            }
        }
        return $this;
    }

    /**
     * Get config key
     *
     * @param $key
     * @return mixed|void
     * @throws ConfigException
     */
    function get($key)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        } else {
            throw new ConfigException('Key `' . $key . '` is not exists in config');
        }
    }


}