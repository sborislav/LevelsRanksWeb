<?php

namespace LevelsRanks;

use LevelsRanks\Entity\SteamPlayer;

class Steam
{
    /**
     * @var int SteamID64
     */
    private $steam;

    /**
     * @var SteamPlayer
     */
    private $entitySteam;

    /**
     * @var null|array
     */
    private $games;

    public function __construct($steamid, $game = null)
    {
        if ( !isset($this->steam) )
            $this->steam = LevelsRanks::SteamConvert($steamid, false);

        if ( is_null($game) ) {
            $this->entitySteam = new SteamPlayer();

            $json2 = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . LevelsRanks::$STEAM_API . "&steamids=" . $this->steam));
            if (!empty($json2->response->players[0])) {
                foreach ($json2->response->players[0] as $key => $value) {
                    if (property_exists($this->entitySteam, $key)) $this->entitySteam->$key = $value;
                }
            } else {
                $this->entitySteam->avatarfull = "images/levelsranks/noname.png";
            }
        } else
            $this->games = $game;
    }

    public function setGame($games)
    {
        $this->games = $games;
        return $this;
    }


    /**
     * @return array
     */
    public function statistic()
    {
        $gameArray = array();
        foreach ($this->games as $game) {
            $classname = "LevelsRanks\Game\game$game";
            /**
             * @var $gameArray[] Game
             */
            $gameArray[] = new $classname($this->steam);
        }
        return $gameArray;
    }

    public function __get($name)
    {
        return $this->entitySteam->$name;
    }
}