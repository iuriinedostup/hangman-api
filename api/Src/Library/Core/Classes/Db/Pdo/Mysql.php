<?php

namespace Src\Library\Core\Classes\Db\Pdo;

use Src\Library\Core\Exceptions\DbException;
use Src\Library\Core\Interfaces\Classes\Db\iDb;

class Mysql extends \PDO implements iDb
{
    /**
     * Create database connection
     */
    function __construct($data){

        try {
            parent::__construct('mysql:host='.$data['host'].';dbname='.$data['name'],$data['user'],$data['password']);
            $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
        } catch(\PDOException $e){
            throw new DbException($e->getMessage(), $e->getCode());
        }

    }

    /**
     * Select records from a database
     * @param string $sql
     * @param array $params
     * @param object $fetchMode
     * @return array returns an array of records
     */
    public function select($sql, $params = array(), $fetchMode = \PDO::FETCH_OBJ)
    {

        $stmt = $this->prepare($sql);
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $stmt->bindValue($key, $value, \PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        try {
            $stmt->execute();
        } catch (\PDOException $e) {
            return array();
        }
        return $stmt->fetchAll($fetchMode);
    }

    /**
     * Insert data in a table
     * @param string $table table name
     * @param array $data array of columns and values
     */
    public function insert($table, $data)
    {
        ksort($data);

        $fieldNames = implode(',', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $stmt = $this->prepare("INSERT INTO " . $table . " (" . $fieldNames . ") VALUES (" . "$fieldValues)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }

        if ($stmt->execute()) {
            return $this->lastInsertId();
        }
        return false;
    }

    /**
     * Update a table by data
     * @param string $table table name
     * @param array $data array of columns and values
     * @param array $where array of columns and values
     */
    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;
        foreach ($data as $key => $value) {
            $fieldDetails .= $key . " = :" . $key . ",";
        }
        $fieldDetails = rtrim($fieldDetails, ',');

        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= $key . " = :" . $key;
            } else {
                $whereDetails .= " AND " . $key . " = :" . $key;
            }

            ++$i;
        }
        $whereDetails = ltrim($whereDetails, ' AND ');

        $stmt = $this->prepare("UPDATE " . $table . " SET " . $fieldDetails . " WHERE " . $whereDetails);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }

        foreach ($where as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }
        return $stmt->execute();
    }

    /**
     * Delete from table
     * @param string $table table name
     * @param array $where array of columns and values
     * @param integer $limit limit number of records
     */
    public function delete($table, $where, $limit = 1)
    {
        ksort($where);

        $whereDetails = null;
        $i = 0;
        foreach ($where as $key => $value) {
            if ($i == 0) {
                $whereDetails .= $key . " = :" . $key;
            } else {
                $whereDetails .= " AND " . $key . " = :" . $key;
            }

            ++$i;
        }
        $whereDetails = ltrim($whereDetails, ' AND ');

        $uselimit = "";
        if (is_numeric($limit)) {
            $uselimit = " LIMIT $limit";
        }

        $stmt = $this->prepare("DELETE FROM " . $table . " WHERE " . $whereDetails . $uselimit);

        foreach ($where as $key => $value) {
            $stmt->bindValue(":" . $key, $value);
        }

        return $stmt->execute();
    }

    /**
     * Execute SQL query
     *
     * @param $rawSQL
     * @param int $fetchMode
     * @return array
     */
    public function runSQL($rawSQL, $fetchMode = \PDO::FETCH_OBJ)
    {
        $stmt = $this->prepare($rawSQL);
        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }
}