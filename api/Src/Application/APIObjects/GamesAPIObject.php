<?php

namespace Src\Application\APIObjects;

use Src\Application\Models\Game;
use Src\Application\Models\Word;
use Src\Library\ApplicationConst;
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
        if ($this->getRequest()->getMethod() == ApplicationConst::REQUEST_METHOD_POST) {
            $game = new Game();
            $gameId = $game->createGame();
            $result = array('result' => false);
            if ($gameId) {
                $result['result'] = true;
                $result['gameId'] = $gameId;
            }
            return $result;
        } elseif ($this->getRequest()->getMethod() == ApplicationConst::REQUEST_METHOD_GET) {
            $game = new Game();
            $games = $game->listGames();
            $result = array('result' => $games !== null);
            if ($games) {
                $result['games'] = $games;
            }
            return $result;
        }
        return array('result' => false);
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