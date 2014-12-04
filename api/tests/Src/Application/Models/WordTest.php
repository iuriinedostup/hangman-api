<?php

namespace tests\Src\Application\Models;

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
        $this->removeData();
        $service = Registry::getInstance()->get('config')->get('service');
        $file = $service['wordsFile'];
        $f = fopen($file, 'r');
        $n = $this->_model->loadWords($f);
        $this->assertEquals(4, $n);
    }

    /**
     * @depends testLoadWords
     */
    public function testRandomWord()
    {
        $wordModel = new Word();
        $word = $wordModel->getRandomWord();
        $this->assertTrue($word !== null);
        $this->assertTrue($word->getId() > 0);
        $this->removeData();
    }

    public function removeData()
    {
        $this->_model->getStorage()->exec('TRUNCATE TABLE ' . $this->_model->getTableName());
    }

}