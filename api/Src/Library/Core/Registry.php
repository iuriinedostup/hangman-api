<?php

namespace Src\Library\Core;

/**
 * Class Registry
 * @package Library\Core
 */
final class Registry
{
    private static $_instance = null;
    private $_data = array();

    private function __construct() {}
    private function __clone() {}

    /**
     * Get instance of Registry class
     *
     * @return Registry|null
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Get from Registry by key
     *
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (isset($this->_data[$key])) {
            return $this->_data[$key];
        }
        return null;
    }

    /**
     * Set value to Registry by key
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    }
}