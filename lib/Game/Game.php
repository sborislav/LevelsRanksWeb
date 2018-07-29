<?php

namespace LevelsRanks\Game;

use LevelsRanks\LevelsRanks;

class Game
{
    protected $id = 730;
    protected $name = 'Не известно';
    /**
     * @var int
     */
    protected $kill = 0;

    /**
     * @var int
     */
    protected $death = 0;

    /**
     * @var int|null
     */
    protected $time = null;

    /**
     * @var int
     */
    protected $bombPlanted = 0;

    /**
     * @var int
     */
    protected $bombDefused = 0;

    /**
     * @var int
     */
    protected $win = 0;

    /**
     * @var int
     */
    protected $damage = 0;

    /**
     * @var int
     */
    protected $money = 0;

    /**
     * @var int
     */
    protected $domination = 0;

    /**
     * @var int
     */
    protected $revenge = 0;

    /**
     * @var int
     */
    protected $hit = 0;

    /**
     * @var int
     */
    protected $shot = 0;

    /**
     * @var int
     */
    protected $headshot = 0;

    /**
     * @var int
     */
    protected $killsBlinded = 0;

    /**
     * @var int
     */
    protected $winsKnifeFight = 0;

    /**
     * @var int
     */
    protected $killsEnemyWeapons = 0;

    /**
     * @var int
     */
    protected $winPistolRound = 0;

    public function __construct($steam)
    {

        $json = json_decode(@file_get_contents("http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=$this->id&key=".LevelsRanks::$STEAM_API."&steamid=$steam"));

        if(isset($json)) {
            foreach ($json->playerstats->stats as $value) {
                if ( isset($this->array[$value->name])) {
                    $this->{$this->array[$value->name]} = $value->value;
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getKill()
    {
        return $this->kill;
    }

    /**
     * @return int
     */
    public function getDeath()
    {
        return $this->death;
    }

    /**
     * @return int|null
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getBombPlanted()
    {
        return $this->bombPlanted;
    }

    /**
     * @return int
     */
    public function getBombDefused()
    {
        return $this->bombDefused;
    }

    /**
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * @return int
     */
    public function getDomination()
    {
        return $this->domination;
    }

    /**
     * @return int
     */
    public function getHeadshot()
    {
        return $this->headshot;
    }

    /**
     * @return int
     */
    public function getHit()
    {
        return $this->hit;
    }

    /**
     * @return int
     */
    public function getKillsBlinded()
    {
        return $this->killsBlinded;
    }

    /**
     * @return int
     */
    public function getKillsEnemyWeapons()
    {
        return $this->killsEnemyWeapons;
    }

    /**
     * @return int
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * @return int
     */
    public function getRevenge()
    {
        return $this->revenge;
    }

    /**
     * @return int
     */
    public function getShot()
    {
        return $this->shot;
    }

    /**
     * @return int
     */
    public function getWin()
    {
        return $this->win;
    }

    /**
     * @return int
     */
    public function getWinPistolRound()
    {
        return $this->winPistolRound;
    }

    /**
     * @return int
     */
    public function getWinsKnifeFight()
    {
        return $this->winsKnifeFight;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}