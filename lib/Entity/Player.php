<?php

namespace LevelsRanks\Entity;

use LevelsRanks\Core\Weapons;
use LevelsRanks\Hits;
use LevelsRanks\LevelsRanks;

class Player implements PlayerInterface
{
    /** @var int */
    private $id;

    /** @var int Очки */
    private $value;

    /** @var string */
    private $steam;

    /** @var string */
    private $steam64;

    /** @var string Имя игрока */
    private $name;

    /** @var int Уровень ранга */
    private $rank;

    /** @var int Количество убийст */
    private $kills;

    /** @var int Количество смертей */
    private $deaths;

    /** @var int Количество выстрелов */
    private $shoots;

    /** @var int Попаданий всего */
    private $hits;

    /** @var int Убийств в голову */
    private $headshots;

    /** @var int Помощь в убийств */
    private $assists;

    /** @var int Количество выйгранных раундов */
    private $round_win;

    /** @var int Количество проигранных раундов */
    private $round_lose;


    /** @var int Время игры на сервере */
    private $playtime;

    /** @var int Последнее подключение*/
    private $lastconnect;


    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getSteam()
    {
        return $this->steam;
    }

    public function getSteamSlim()
    {
        return str_replace('STEAM_1:', '', $this->steam);
    }

    public function getSteam64()
    {
        return $this->steam64 ? $this->steam64 : $this->steam64 = LevelsRanks::SteamConvert($this->steam, false);
    }


    private function avatarCache()
    {
        if ( !$this->cache && LevelsRanks::$config->CACHE ){
            $cacheFile = ROOT."images/levelsranks/cache/$this->steam64.jpg";
            if (file_exists($cacheFile) && (time() - LevelsRanks::$config->CACHETIME) < filemtime($cacheFile) ) {
                return $this->cache = true;
            }
        }
        return $this->cache;
    }

    public function hasAvatar()
    {
        if ( is_null(LevelsRanks::$STEAM_API) )
            return 0;

        if ( LevelsRanks::$config->cacheSteamAva && LevelsRanks::$avatar->has($this->getSteam64())){
            return 0;
        }

        if ( $this->avatarCache() ){
            return 0;
        }

        return $this->getSteam64();
    }

    private $cache = false;

    public function getAvatar()
    {
        if ( is_null(LevelsRanks::$STEAM_API) )
            return "images/levelsranks/noname40.png";

        if ( LevelsRanks::$config->cacheSteamAva && LevelsRanks::$avatar->has($this->getSteam64())){
            return LevelsRanks::$avatar->get($this->getSteam64());
        }

        if ( $this->avatarCache()  ){
            return "images/levelsranks/cache/$this->steam64.jpg";
        }
        return "images/levelsranks/loading.gif";
    }

    public function getName()
    {
        return $this->name == '' ? 'Unnamed' : $this->name;
    }

    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @var Weapons
     */
    private $kill_obj = null;

    /**
     * @return int|Weapons
     * @throws \Exception
     */
    public function getKills($obj = false, $game = null)
    {
        if (!empty($this->kill_obj)) {
            $this->kill_obj->setGame($game);
            if ($obj)
                return $this->kill_obj;
            else
                return $this->kill_obj->All();
        }

        $this->kill_obj = new Weapons($this->kills, $game);
        if ($obj)
            return $this->kill_obj;
        else
            return $this->kill_obj->All();
    }

    public function getDeaths()
    {
        return $this->deaths;
    }

    /**
     * КД в процентах
     * @return float|int
     */
    public function getKD()
    {
        return $this->getDeaths() ? round($this->getKills()*100/$this->getDeaths(),2) : 0;
    }

    /**
     * КД в числах
     * @return float|int
     */
    public function getKD2()
    {
        return $this->getDeaths() ? round($this->getKills()/$this->getDeaths(),2) : 0;
    }

    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * @var Weapons
     */
    private $headshots_obj = null;

    /**
     * @param bool $obj
     * @return int|Weapons
     * @throws \Exception
     */
    public function getHeadshots($obj = false)
    {
        if (!empty($this->headshots_obj)){
            if ($obj)
                return $this->headshots_obj;
            else
                return $this->headshots_obj->All();
        }

        $this->headshots_obj = new Weapons($this->headshots);
        if ($obj)
            return $this->headshots_obj;
        else
            return $this->headshots_obj->All();
    }

    function getShoots()
    {
        return $this->shoots;
    }

    /**
     * @var Hits
     */
    private $hist_obj = null;

    /**
     * @param bool $int
     * @return int|Hits
     */
    function getHits($obj = false)
    {
        if (!empty($this->hist_obj)){
            if ($obj)
                return $this->hist_obj;
            else
                return $this->hist_obj->All();
        }

        $this->hist_obj = new Hits($this->hits);
        if ($obj)
            return $this->hist_obj;
        else
            return $this->hist_obj->All();
    }

    /**
     * процент попаданий
     * @return float|int
     */
    public function getHS()
    {
        return $this->getShoots() ? round($this->getHits()*100/$this->getShoots(),2) : 0;
    }

    function getHitsHead()
    {
        return $this->getHits(true)->head;
    }

    function getHitsChest()
    {
        return $this->getHits(true)->chest;
    }

    function getHitsStomach()
    {
        return $this->getHits(true)->stomach;
    }

    function getHitsArms()
    {
        return $this->getHits(true)->arms;
    }

    function getHitsLegs()
    {
        return $this->getHits(true)->legs;
    }

    /**
     * @return int
     */
    public function getRoundLose()
    {
        return $this->round_lose;
    }

    /**
     * @return int
     */
    public function getRoundWin()
    {
        return $this->round_win;
    }


    public function getPlaytime($sec = false)
    {
        if ($sec)
            return $this->playtime;


        if ( $this->playtime > 31536000 )
            return 'Больше года';
        else {
            return $this->time($this->playtime);
        }
    }

    function getLastconnect($unix = false)
    {
        if (!$unix) {
            if (LevelsRanks::$config->formatDate) {
                return $this->newtime();
            } else {
                return date('%d.%m.%y', $this->lastconnect);
            }
        } else {
            return $this->lastconnect;
        }
    }

    private function newtime($lastconnect = null)
    {
        if (is_null($lastconnect))
            $lastconnect = $this->lastconnect;
        $time = time()-$lastconnect;
        if ( $time <  300)
            return 'Менее 5 минут';
        if ($time < 3600)
            return 'Менее часа';
        if ($time < 86400) {
            $h = (int)($time/3600);
            if ($h == 1)
                return 'Час назад';
            if ($h > 1 && $h <= 4)
                return $h.' часа назад';
            if ( $h > 4  && $h < 21 )
                return $h.' часов назад';
            if ( $h == 21 )
                return $h.' час назад';
            if ( $h > 21 )
                return $h.' часа назад';
        }
        if ( $time < 2592000 ) {
            $d = (int)$time/86400;
            if ($d == 1)
                return 'Вчера';
            if ($d > 1 && $d <= 4)
                return $h.' дня назад';
            if ( $d > 7 && $d < 7)
                return $h.' дней назад';
            if ( $d >= 7 && $d < 14)
                return 'Неделю назад';
            if ( $d >= 14 ){
                $w = (int)($d/7);
                return $w . ' недели назад';
            }
        }
        return date('d.m.y', $this->lastconnect);
    }


    /**
     * Работа со временными значениями
     * @var array
     */
    private $new_param = array();

    public function __get($name)
    {
        if (isset($this->new_param[$name])) return $this->new_param[$name];
        return null;
    }

    public function __set($name, $value)
    {
        if (!isset($this->$name)) $this->new_param[$name] = $value;
        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
       return $this->getSteam();
    }


    function time($seconds)
    {
        $string = array(
            'seconds' => [' секунда', ' секунды', ' секунд'],
            'minutes' => [' минута', ' минуты', ' минут'],
            'hours' => [' час', ' часа', ' часов'],
            'days' => [' день', ' дня', ' дней'],
            'week' => [' неделя', ' недели', ' недель'],

        );
        $str = '';
        foreach ( $this->periodAgo($seconds) as $key=>$value )
        {
            if ($value == 0) continue;

            if ( $value > 10 && $value < 15 ) {
                $str = $value.$string[$key][2].' '.$str;
            } else {
                $last = substr($value, -1);
                if ( $last == 1 )
                    $str = $value.$string[$key][0].' '.$str;
                elseif ($last > 1 && $last < 5)
                    $str = $value.$string[$key][1].' '.$str;
                else
                    $str = $value.$string[$key][2].' '.$str;
            }
        }
        return $str;
    }

    function periodAgo($seconds)
    {



        $times = [
            'seconds' => $seconds,
            'minutes' => 0,
            'hours' => 0,
            'days' => 0,
            'week' => 0
        ];

        // Считаем минуты
        $minutes = floor($seconds / 60);
        if ($minutes > 0) {
            $seconds -= $minutes * 60;

            $times['seconds'] = $seconds;
            $times['minutes'] = $minutes;

            // Считаем часы
            $hours = floor($minutes / 60);
            if ($hours > 0) {
                $minutes -= $hours * 60;

                $times['minutes'] = $minutes;
                $times['hours'] = $hours;

                // Считаем дни
                $days = floor($hours / 24);
                if ($days > 0) {
                    $hours -= $days * 24;

                    $times['hours'] = $hours;
                    $times['days'] = $days;

                    // Считаем недели
                    $week = floor($days / 7);
                    if ($week > 0) {
                        $days -= $week * 7;

                        $times['days'] = $days;
                        $times['week'] = $week;
                    }
                }
            }
        }
        return $times;
    }
}
