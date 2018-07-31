<?php

namespace LevelsRanks;


class LevelsRanks
{
    /**
     * @var Server
     */
    private $serverOBJ;

    /**
     * @var Steam
     */
    private $steamOBJ;

    static $STEAM_API;
    static $ROOT_DIR;
    static $avatar;
    static public $config;

    /**
     * LevelsRanks constructor.
     * @param null $steam_api STEAM_API ключ
     * @param string $rootdir Корневая директория сайта, должна оканчиваться '/'
     */
    public function __construct($steam_api = null, $rootdir = '')
    {
        self::$STEAM_API = $steam_api;
        self::$ROOT_DIR = $rootdir;
        self::$avatar = new Avatars();
        self::$config = new Config();
    }

    /**
     * Принудительная установка STEAM_KEY, необходима для совместимости
     * @param null $steam_api
     * @return $this
     */
    public function setSteamAPI($steam_api = null)
    {
        self::$STEAM_API = $steam_api;
        return $this;
    }

    /**
     * Принудительная установка корневого каталога, необходима для совместимости
     * @param string $rootdir
     * @return $this
     */
    public function setRootDir($rootdir = '')
    {
        self::$ROOT_DIR = $rootdir;
        return $this;
    }

    /**
     * @return Config
     */
    public function Config()
    {
        return self::$config;
    }

    /**
     * Обновление LR на всех таблицах
     * @param string $sql
     * @return bool
     */
    public function Update($sql = '')
    {
        if(!empty($sql)) {
            foreach ($this->Server()->getAll() as $server) {
                if ( !$server->Update($sql) )
                    return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Получение информации от игроке по всем серверам
     * @param $steamid32
     * @return array
     */
    public function Player($steamid32)
    {
        return $this->serverOBJ->Player($steamid32);
    }

    /**
     * @return Steam
     */
    public function Steam($id, $game = null)
    {
        return $this->steamOBJ && !is_null($game) ? $this->steamOBJ->setGame($game) : $this->steamOBJ = new Steam($id, $game);
    }

    /**
     * @return Server
     */
    public function Server()
    {
        return  $this->serverOBJ ? $this->serverOBJ : $this->serverOBJ = new Server();
    }

    /**
     * Перевод стим в формат Steam_id2 STEAM_X:Y:Z
     * @param $steam
     * @param $go  boolean если true - то в steam :Y:Z, false - steam64
     * @return bool|string
     */
    static public function SteamConvert($steam, $go = true)
    {
        if ($go)
            return self::steam_to($steam);
        else
            return self::steam_from($steam);
    }

    /**
     * Преобразует любой полученый steamID в :Y:Z для поиска по базе
     * @param $steam
     * @return bool|string
     */
    static function steam_to($steam)
    {
        if ( preg_match('/\d{16,}/', $steam)) {
            // steamID 64
            $z = bcdiv(bcsub($steam, '76561197960265728'), '2');
            $y = bcmod($steam, '2');
            $steam = ":$y:".floor($z);
        }elseif ( preg_match('/^(steam_)/i', $steam) ) {
            // steamID
            preg_match('/:[0|1]:\d+$/', $steam, $steam );
            $steam = $steam[0];

        } elseif ( preg_match('/^\[?u:/i', $steam) ) {
            // steamID 3
            preg_match('/(\d+)\]?$/', $steam, $steam);
            $steam = $steam[1];
            $z = bcdiv($steam, '2');
            $y = bcmod($steam, '2');
            $steam = ":$y:".floor($z);
        }
        if ( isset($steam) )
            return $steam;
        else
            return false;
    }

    /**
     * Преобразует любой SteamID в Steam64 для работы со steam
     * @param $steam
     * @return string|bool
     */
    static function steam_from($steam)
    {
        if ( preg_match('/^(steam_)/i', $steam) ) {
            $parts = explode(':', $steam);
            return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);

        } elseif ( preg_match('/^\[?u:/i', $steam) ) {
            preg_match('/(\d+)\]?$/', $steam, $steam);
            return bcadd($steam, '76561197960265728');
        } elseif (preg_match('/\d{16,}/', $steam)) {
            return $steam;
        } else {
            $parts = explode(':', $steam);
            return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
        }
    }
}
