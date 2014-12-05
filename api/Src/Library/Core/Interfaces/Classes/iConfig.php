<?php

namespace Src\Library\Core\Interfaces\Classes;

use Src\Library\Core\Exceptions\ConfigException;

interface iConfig
{
    /**
     * Load and parse config file
     *
     * @return mixed
     */
    function _load();

    /**
     * Get config key
     *
     * @param $key
     * @return mixed|void
     * @throws ConfigException
     */
    function get($key);

}