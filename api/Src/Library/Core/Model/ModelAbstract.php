<?php

namespace Src\Library\Core\Model;

use Src\Library\Core\Exceptions\DbException;
use Src\Library\Core\Interfaces\Classes\Db\iDb;
use Src\Library\Core\Interfaces\Model\iModel;
use Src\Library\Core\Registry;
use Src\Library\Core\Response\Response;

abstract class ModelAbstract implements iModel
{
    protected $_storage;
    protected $_pkName = false;
    protected $_metaData;

    protected static $_instance = null;

    /**
     * Set model storage
     *
     * @param mixed $storage
     */
    public function setStorage($storage)
    {
        $this->_storage = $storage;
    }

    /**
     * Returns model storage
     *
     * @return iDb
     */
    public function getStorage()
    {
        return $this->_storage;
    }

    public function getMetaData()
    {
        return $this->_metaData;
    }

    protected function setMetaData($data)
    {
        $this->_metaData = $data;
    }


    /**
     * Init storage, metadata, and model initialization
     *
     * @param null $storage
     */
    final public function __construct($storage = null)
    {
        if ($storage == null) {
            $db = Registry::getInstance()->get('db');
            if ($db == null) {
                throw new DbException('Database is not loaded.', Response::HTTP_RESPONSE_CODE_ISE);
            }
            $this->setStorage($db);

            //Retrieve table columns and primary key
            $this->setMetaData($this->getStorage()->getMetaData($this->getTableName()));
            $this->getPkName();
            $this->init();
        }
    }

    /**
     * Init model, runs from constructor
     */
    public function init()
    {

    }

    /**
     * Get table primary key
     *
     * @return bool
     */
    protected function getPkName()
    {
        if ($this->_pkName != false) {
            return $this->_pkName;
        }
        $data = $this->getStorage()->select("SHOW KEYS FROM `" . $this->getTableName() . "` WHERE Key_name = 'PRIMARY'");
        if (isset($data[0])) {
            $data = $data[0];
            $this->_pkName = $data->Column_name;
        }
        return $this->_pkName;
    }

    /**
     * Create and return normalized to object name
     *
     * @param $name
     * @return string
     */
    private function _fromKey($name)
    {
        $segs = explode('_', trim($name, '_'));
        $name = implode('', array_map('ucfirst', $segs));
        return '_' . lcfirst($name);
    }

    /**
     * Create and return method name for access to property
     *
     * @param $name
     * @param string $type
     * @return string
     */
    private function _propAccessFunc($name, $type = 'get')
    {
        $name = $this->_fromKey($name);
        if (!in_array($type, array('get', 'set'))) {
            $type = 'get';
        }
        return $type . ucfirst(trim($name, '_'));
    }

    /**
     * Create and return property name from object property
     *
     * @param $property
     * @return string
     */
    private function _toKey($property)
    {
        $parts = preg_split('/(?=\p{Lu})/u', $property);

        $key = '';
        foreach($parts as $word) {
            $key .= '_'.lcfirst($word);
        }

        return substr($key, 2);
    }

    /**
     * Set data from array to model properties
     *
     * @param $data
     * @return $this
     */
    public function setData($data)
    {
        $props = get_class_vars(get_class($this));

        foreach ($data as $name=>$item) {
            $normalizedName = $this->_fromKey($name);
            $setFunc = $this->_propAccessFunc($name, 'set');
            if (array_key_exists($normalizedName, $props) && method_exists($this, $setFunc)) {
                call_user_func(array($this, $setFunc), $item);
            }
        }
        return $this;
    }

    /**
     * Return model properties as array
     *
     * @return array
     */
    public function getData()
    {
        $props = get_class_vars(get_class($this));

        $d = array();
        foreach ($props as $name => $data) {
            $f = $this->_propAccessFunc($name);
            if (in_array($this->_toKey($name), $this->getMetaData()) && method_exists($this, $f)) {
                $value = $this->$f();
                $d[$this->_toKey($name)] = $value;
            }
        }
        return $d;
    }

    /**
     * Save model data to storage
     *
     * @return mixed
     */
    public function save()
    {
        $data = $this->getData();
        if (array_key_exists($this->getPkName(), $data) && !empty($data[$this->getPkName()])) {
            $pk = $data[$this->getPkName()];
            unset($data[$this->getPkName()]);
            return $this->getStorage()->update($this->getTableName(), $data, array($this->getPkName() => $pk));
        } else {
            unset($data[$this->getPkName()]);
            return $this->getStorage()->insert($this->getTableName(), $data);
        }
    }

    /**
     * Retrieve data from storage by parameters
     *
     * @param $params
     * @return array
     */
    public function find($params, $order = null, $limit = null)
    {
        $result = array();
        $sql = "SELECT " . implode(',', $this->getMetaData()) . " FROM `" . $this->getTableName() . "`";
        if (!empty($params)) {
            $sql = $sql . 'WHERE ';
            foreach($params as $key=>$value) {
                $sql .= $key . ' = ' . ':'.$key . ' ';
            }
            $sql = rtrim($sql);
        }
        $data = $this->getStorage()->select($sql, $params, $order, $limit);
        foreach ($data as $row) {
            $model = clone $this;
            $model->setData($row);
            $result[] = $model;
        }
        unset($model);
        return $result;
    }

    /**
     * Find one row by params according to order
     *
     * @param array $params
     * @param null $order
     * @return null
     */
    public function findOneBy($params = array(), $order = null)
    {
        $data = $this->find($params, $order, array(1));
        if ($data) {
            return $data[0];
        }
        return null;
    }

    /**
     * Delete record by ID
     *
     * @param $id
     */
    public function delete($id)
    {
        if ((int) $id) {
            $this->getStorage()->delete($this->getTableName(), array($this->getPkName() => $id));
        }
    }

    /**
     * Find data in the storage by Id and return model object
     *
     * @param $id
     * @return $this|bool
     */
    public function findById($id)
    {
        $data = $this->findOneBy(array('id' => $id));
        if ($data) {
            return $data;
        }
        return false;
    }

    /**
     * Retrieve all data from the storage
     *
     * @return array
     */
    public function findAll($order = null, $limit = null)
    {
        $result = array();
        $data = $this->getStorage()->select("SELECT " . implode(',', $this->getMetaData()) . " FROM `" . $this->getTableName() . "`", array(), $order, $limit);
        foreach ($data as $row) {
            $model = clone $this;
            $model->setData($row);
            $result[] = $model;
        }
        unset($model);
        return $result;
    }

    /**
     * Run raw SQL and return result
     *
     * @param $rawSql
     * @param int $fetchMode
     * @return mixed
     */
    public function runSQL($rawSql, $fetchMode = \PDO::FETCH_OBJ)
    {
        return $this->getStorage()->runSQL($rawSql, $fetchMode);
    }

}