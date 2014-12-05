<?php

namespace Src\Application\Models;

use Src\Library\Core\Exceptions\ApplicationException;
use Src\Library\Core\Model\ModelAbstract;

class Word extends ModelAbstract
{
    protected $_id;
    protected $_word;
    protected $_is_deleted;

    public function getTableName()
    {
        return 'words';
    }

    public static function model()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
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
    public function getIsDeleted()
    {
        return $this->_is_deleted;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->_is_deleted = $is_deleted;
    }

    /**
     * @return mixed
     */
    public function getWord()
    {
        return $this->_word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->_word = $word;
    }

    /**
     * Load words to DB from file
     *
     * @param $file
     * @return int
     */
    public function loadWords($file)
    {
        $i = 0;
        if ($file) {
            while (($line = fgets($file)) !== false) {
                $word = $this->findOneBy(array('word' => trim($line)));
                if (!empty($word) && $word->getId()) {
                    continue;
                }
                $model = clone $this;
                $model->setWord(trim($line));
                $model->setIsDeleted(0);
                $model->save();
                ++$i;
            }
        }
        return $i;
    }

    /**
     * Return random word from DB
     *
     * @return null
     */
    public function getRandomWord()
    {
        $word = $this->findOneBy(array(), 'RAND()');
        return $word;
    }

}