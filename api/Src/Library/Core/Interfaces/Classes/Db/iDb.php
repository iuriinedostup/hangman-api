<?php

namespace Src\Library\Core\Interfaces\Classes\Db;

interface iDb
{
    public function insert($table, $data);
    public function update($table, $data, $where);
    public function select($sql, $params = array(), $fetchMode  = \PDO::FETCH_OBJ);
    public function delete($table, $where, $limit = 1);
    public function runSQL($rawSQL, $fetchMode = \PDO::FETCH_OBJ);
    public function getMetaData($resource);
}