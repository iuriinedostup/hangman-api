<?php

namespace Src\Library\Core\Interfaces\Model;

interface iModel
{
    public function getTableName();
    public function save();
    public function find($params, $order = null, $limit = null);
    public function findAll($order = null, $limit = null);
    public function findById($id);
    public function delete($id);
    public function setData($data);
    public function getData();
    public function getMetaData();
    public static function model();
}