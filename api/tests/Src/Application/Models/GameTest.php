<?php

namespace tests\Src\Application\Models;

use Src\Application\Models\Game;
use Src\Application\Models\Word;
use Src\Library\Core\Registry;

class GameTest extends \PHPUnit_Framework_TestCase
{
    protected $_game;
    protected $_word;
    protected $_file;

    /**
     * Set up models for test and words file handler
     */
    public function setUp()
    {
        $this->_game = new Game();
        $this->_word = new Word();
        $service = Registry::getInstance()->get('config')->get('service');
        $file = $service['wordsFile'];
        $f = fopen($file, 'r');
        $this->_file = $f;

    }

    /**
     * Test for create new game
     *
     * @return mixed
     */
    public function testCreateGame()
    {
        $this->removeData();
        $this->_word->loadWords($this->_file);
        $game = new Game();
        $rw = $this->_word->getRandomWord();
        $game->setWordId($rw->getId());
        $game->setUserInput('');
        $game->setGuessWord(preg_replace('/./','.', trim($rw->getWord())));
        $id = $game->save();
        $this->assertEquals($id, 1);
        return $id;
    }

    /**
     * List all games
     *
     * @depends testCreateGame
     */
    public function testListGames($id)
    {
        $game = new Game();
        $games = $game->listGames();

        $this->assertTrue(is_array($games));
        $this->assertEquals(1, count($games));
        return $id;
    }

    /**
     * Test search by game ID
     *
     * @depends testListGames
     */
    public function testFindById($id)
    {
        $this->assertTrue($id > 0);
        $game = $this->_game->findOneBy(array('id' => $id));
        $this->assertNotNull($game);
        $this->assertEquals($id, $game->getId());
        $this->assertEquals(Game::STATUS_BUSY, $game->getStatus());
    }

    /**
     * Test deleting game from DB table
     *
     * @depends testListGames
     */
    public function testRemoveGame($id)
    {
        $this->assertTrue($id > 0);
        $this->_game->delete($id);
        $game = $this->_game->findOneBy(array('id' => $id));
        $this->assertNull($game);
        $this->removeData();
    }

    /**
     * Remove test data
     */
    public function removeData()
    {
        $this->_game->getStorage()->exec('TRUNCATE TABLE ' . $this->_game->getTableName());
        $this->_word->getStorage()->exec('TRUNCATE TABLE ' . $this->_word->getTableName());
    }
}