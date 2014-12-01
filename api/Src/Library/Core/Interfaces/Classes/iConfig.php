<?php

namespace Src\Library\Core\Interfaces\Classes;

interface iConfig
{
    /**
     * Load and parse config file
     *
     * @return mixed
     */
    function _load();

    /**
     * Config key
     *
     * @param $key
     * @return mixed
     */
    function get($key);

}