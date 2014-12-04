<?php
namespace tests\Src\Library\Core\Db;

use Src\Library\Core\Db\Db;
use Src\Library\Core\Registry;

class DbTest extends \PHPUnit_Framework_TestCase
{
    protected $_config;

    public function setUp()
    {
        $this->_config = Registry::getInstance()->get('config');
    }

    public function testDbConnection()
    {
        $db = Db::factory($this->_config->get('db'));
        $this->assertTrue($db !== null);
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Classes\Db\iDb', $db);
    }
}