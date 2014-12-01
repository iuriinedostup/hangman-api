<?php

namespace Src\Library\Core\Classes;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\ConfigException;
use Src\Library\Core\Interfaces\Classes\iConfig;

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
        $config = parse_ini_file($this->_fileName);
        if (empty($config)) {
            return $this;
        }
        foreach ($config as $key=>$value) {
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
     * Config key
     *
     * @param $key
     * @return mixed
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