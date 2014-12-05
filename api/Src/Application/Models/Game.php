<?php

namespace Src\Application\Models;

use Src\Library\Core\Model\ModelAbstract;

class Game extends ModelAbstract
{

    protected $_id;
    protected $_wordId;
    protected $_userInput;
    protected $_guessWord;
    protected $_status;
    protected $_tiersLeft;
    protected $_startDate;

    protected $_word;

    const STATUS_BUSY = 'busy';
    const STATUS_FAIL = 'fail';
    const STATUS_SUCCESS = 'success';

    const TIERS_DEFAULT = 11;

    public static function model()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function init()
    {
        $this->setStatus(self::STATUS_BUSY);
        $this->setTiersLeft(self::TIERS_DEFAULT);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->_startDate = $start_date;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @param mixed $tiers_left
     */
    public function setTiersLeft($tiers_left)
    {
        $this->_tiersLeft = $tiers_left;
    }

    /**
     * @return mixed
     */
    public function getTiersLeft()
    {
        return $this->_tiersLeft;
    }

    /**
     * @param mixed $word_id
     */
    public function setWordId($word_id)
    {
        $this->_wordId = $word_id;
    }

    /**
     * @return mixed
     */
    public function getWordId()
    {
        return $this->_wordId;
    }

    /**
     * @param mixed $guessWord
     */
    public function setGuessWord($guessWord)
    {
        $this->_guessWord = $guessWord;
    }

    /**
     * @return mixed
     */
    public function getGuessWord()
    {
        return $this->_guessWord;
    }

    /**
     * @param mixed $userInput
     */
    public function setUserInput($userInput)
    {
        $this->_userInput = $userInput;
    }

    /**
     * @return mixed
     */
    public function getUserInput()
    {
        return $this->_userInput;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->_word = $word;
    }

    /**
     * @return Word
     */
    public function getWord()
    {
        return $this->_word;
    }

    public function getTableName()
    {
        return 'games';
    }

    /**
     * Overwrite function for select related word to the model
     *
     * @param $data
     * @return $this|void
     */
    public function setData($data)
    {
        parent::setData($data);
        if ($this->getWordId()) {
            $this->setWord(Word::model()->findById($this->getWordId()));
        }
    }

    /**
     * Create new game
     *
     * @return mixed|null
     */
    public function createGame()
    {
        $randomWord = Word::model()->getRandomWord();
        if ($randomWord) {
            $this->setWordId($randomWord->getId());
            $this->setGuessWord(preg_replace('/./','.', trim($randomWord->getWord())));
            $this->setUserInput('');
            return $this->save();
        }
        return null;
    }

    /**
     * Get all games
     *
     * @param null $order
     * @param null $limit
     * @return array
     */
    public function listGames($order = null, $limit = null)
    {
        $games = $this->findAll($order, $limit);
        if (empty($games)) {
            return null;
        }
        $data = array();
        foreach ($games as $game) {
            $data[] = array('id'         => $game->getId(),
                            'status'     => $game->getStatus(),
                            'start_date' => $game->getStartDate(),
                            'tiers_left' => $game->getTiersLeft()
            );
        }
        return $data;
    }

    /**
     * Get game by ID and prepare data
     *
     * @param $id
     * @param bool $active
     * @return array|null
     */
    public function getGameById($id, $active = true)
    {
        if (!(int) $id) {
            return null;
        }
        $params = array('id' => $id);
        if ($active) {
            $params['status'] = self::STATUS_BUSY;
        }
        $game = $this->findOneBy($params);
        if ($game) {
            $data = $this->getGameData($game);
            return $data;
        }
        return null;
    }

    /**
     * Prepare game data for response
     *
     * @param Game $game
     * @return array
     */
    public function getGameData(Game $game)
    {
        $data = array(
            'id' => $game->getId(),
            'word' => $game->getGuessWord(),
            'tiers_left' => $game->getTiersLeft(),
            'status' => $game->getStatus()
        );
        return $data;
    }

    /**
     * Process game by ID and user`s input char
     *
     * @param $id
     * @param $char
     * @return $this|bool
     */
    public function processGame($id, $char)
    {
        $game = $this->findById($id);
        if (!$game) {
            return null;
        }
        $game->setUserInput($game->getUserInput() . $char);
        $game->setTiersLeft($game->getTiersLeft() > 0 ? $game->getTiersLeft() - 1 : $game->getTiersLeft());
        if ($game->getTiersLeft() == 0) {
            $game->setStatus(self::STATUS_FAIL);
        }

        $guessWord = $game->getGuessWord();
        $word = $game->getWord()->getWord();
        while (($pos = strpos($word, $char)) !== false) {
            $guessWord{$pos} = $char;
            $word{$pos} = '.';
        }
        $game->setGuessWord($guessWord);
        if ($game->getGuessWord() == $game->getWord()->getWord()) {
            $game->setStatus(self::STATUS_SUCCESS);
        }
        $game->save();
        return $game;
    }

}