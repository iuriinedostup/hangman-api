<?php

namespace Src\Library\Core\Interfaces\Model;

interface iModel
{
    public function getTableName();
    public function save();
    public function find($params);
    public function findAll();
    public function findById($id);
    public function delete($id);
    public function setData($data);
    public function getData();
    public function getMetaData();
}