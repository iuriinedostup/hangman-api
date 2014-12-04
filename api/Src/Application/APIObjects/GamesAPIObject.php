<?php

namespace Src\Application\APIObjects;

use Src\Library\Core\Classes\APIObject;

class GamesAPIObject extends APIObject
{
    /**
     * List of games
     *
     * @return array
     */
    public function indexFunction()
    {
        return array('result' => 'ok');
    }

    /**
     * Manage game
     *
     * @return array
     */
    public function manageFunction()
    {
        return array('result' => 'ok');
    }
}