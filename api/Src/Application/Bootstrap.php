<?php

namespace Src\Application;

use Src\Library\Core\BootstrapAbstract;
use Src\Library\Core\Db\Db;
use Src\Library\Core\Registry;

class Bootstrap extends BootstrapAbstract
{

    /**
     * Get DB connection and save to Registry
     *
     * @throws \Src\Library\Core\Exceptions\DbException
     */
    protected function _initDb()
    {
        $config = Registry::getInstance()->get('config');
        $db = Db::factory($config->get('db'));
        Registry::getInstance()->set('db', $db);
    }
}