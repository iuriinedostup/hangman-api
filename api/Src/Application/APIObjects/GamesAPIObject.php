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
        $id = $this->getRequest()->getParam('id', false);
        if (!((int) $id)) {
            return array('result' => false, 'message' => 'Incorrect game ID');
        }
        if ($this->getRequest()->getMethod() == ApplicationConst::REQUEST_METHOD_GET) {
            $model = new Game();
            $game = $model->getGameById($id);
            if ($game) {
                return array('result' => true, 'game' => $game);
            }
            return array('result' => false, 'message' => 'Game not found.');
        }
    }
}