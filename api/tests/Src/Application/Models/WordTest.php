<?php

namespace tests\Src\Application\Model;

use Src\Application\Models\Word;
use Src\Library\Core\Interfaces\Model\iModel;
use Src\Library\Core\Registry;

class WordTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var iModel
     */
    protected $_model;

    public function setUp()
    {
        $this->_model = new Word();
    }

    public function testLoadWords()
    {
        $this->_model->getStorage()->exec('TRUNCATE TABLE ' . $this->_model->getTableName());
        $service = Registry::getInstance()->get('config')->get('service');
        $file = $service['wordsFile'];
        $f = fopen($file, 'r');
        $n = $this->_model->loadWords($f);
        $this->assertEquals($n, 4);
        $this->_model->getStorage()->exec('TRUNCATE TABLE ' . $this->_model->getTableName());
    }
}