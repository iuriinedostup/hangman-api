<?php

namespace Src\Library\Core\Db;

use Src\Library\ApplicationConst;
use Src\Library\Core\Exceptions\DbException;

class Db
{
    /**
     * Create DB connection
     *
     * @param $config
     * @return mixed
     * @throws DbException
     */
    public static function factory($config)
    {
        if (!isset($config['adapter'])) {
            throw new DbException('Database adapter is not defined.');
        }

        $ns = ApplicationConst::NS_DB_CLASSES;
        $adapter = str_replace('_', '\\', $config['adapter']);
        $class = $ns . $adapter;
        $db = null;
        if (class_exists($class)) {
            $db = new $class($config);
        }
        return $db;
    }
}