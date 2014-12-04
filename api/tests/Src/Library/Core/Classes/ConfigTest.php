<?php

namespace tests\Src\Library\Core\Classes;

use Src\Library\Core\Classes\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testConfigCreate()
    {
        $configFileName = 'application.ini';
        $config = new Config($configFileName);
        $this->assertInstanceOf('Src\Library\Core\Interfaces\Classes\iConfig', $config);
        return $config;
    }

    /**
     * @depends testConfigCreate
     */
    public function testConfigGetParams($config)
    {
        $db = $config->get('db');
        $this->assertTrue(is_array($db));
        $this->assertTrue(count($db) > 0);
    }
}