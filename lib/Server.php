<?php

namespace LevelsRanks;

use LevelsRanks\Core\Connect;
use LevelsRanks\Core\Source;
use LevelsRanks\Exception\CacheCreateFail;
use LevelsRanks\Entity\Server as EntityServer;
use LevelsRanks\Exception\FailConnect;

class Server extends Source
{
    /**
     * @var EntityServer[]
     */
    private $servers = array();

    /**
     * @var array
     */
    private $gamelist = array();

    private $count = 0;

    public function __construct()
    {
        $this->getAll();
    }

    /**
     * @param string $name Название сервера
     * @param string|int $bd Название базы или id уже уже существующего сервера
     * @param string $user Пользователь для подключения или название таблицы
     * @param string $pass
     * @param string $host
     * @param string $table
     * @param int|null $game
     * @param int $port
     * @param string $charset
     * @return $this
     * @throws FailConnect
     */
    public function add($name, $bd, $user = 'root', $pass = '', $host = '127.0.0.1', $table = 'lvl_base', $game = null, $port = 3306, $charset = "UTF8")
    {
        if ( is_int($bd) ){
            if ( isset($this->servers[$bd]) ){
                $array['connect'] = $bd;
                $array['table'] = $user;
                $array['gameid'] = (int)$pass;
            } else
                throw new FailConnect("Ошибка: данного id подключения не существует");
        } else {
            $array['dsn'] = "mysql:host=$host;dbname=$bd";

            if ($port != 3306)
                $array['dsn'] .= ';port='.$port;

            $array['dsn'] .= ';charset='.$charset;


            $array['table'] = empty($table) ? 'lvl_base' : $table;
            $array['user'] = $user;
            $array['pass'] = $pass;
            $array['gameid'] = in_array($game, [240, 730]) ? $game : 240;
        }
        $array['name'] = $name;
        $array['id'] = $this->count;

        if ( is_int($game) && !in_array($game, $this->gamelist) )
            $this->gamelist[] = $game;

        $server = new EntityServer( $array );
        $temp = $server->getConnect();
        if ( is_integer($temp) )
            static::$connect[$this->count] = &static::$connect[$temp];
        else
            static::$connect[$this->count] = new Connect($temp);

        $this->servers[] = $server;
        $this->count++;
        return $this;
    }

    /**
     * @return $this
     * @throws CacheCreateFail
     */
    public function save()
    {
        $string = "<?php\n return ".var_export($this->servers, true).';';
        if ( file_put_contents(__DIR__.'/Cache/servers.php', $string) === false )
            throw new CacheCreateFail("Ошибка: не удается создать кеш серверов");
        return $this;

    }

    public function count()
    {
        return $this->count;
    }

    /**
     * @param $id
     * @return EntityServer
     */
    public function get($id)
    {
        return $this->servers[$id];
    }

    /**
     * Проверяет существует сервер с данным id
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->servers[$id]);
    }

    public function getAll()
    {
        if ( empty($this->servers) && file_exists(__DIR__.'/Cache/servers.php') ) {
            $servers = include __DIR__.'/Cache/servers.php';
            if (is_array($servers))
                foreach ($servers as $server) {
                    /** @var $server EntityServer */
                    $temp = $server->getConnect();
                    if ( is_integer($temp) )
                        static::$connect[$this->count] = &static::$connect[$temp];
                    else
                        static::$connect[$this->count] = new Connect($temp);

                    if ( is_int($server->getGameId()) && !in_array($server->getGameId(), $this->gamelist) )
                        $this->gamelist[] = $server->getGameId();

                    $this->servers[] = $server;
                    $this->count++;
                }
            else
                $this->servers = array();
        }
        return $this->servers;
    }

    /**
     * Статистика игрока на всех серверах
     *
     * @param $steam32
     * @return \StdClass
     */
    public function Player($steam32)
    {
        $return_obj = new \StdClass();
        $return_obj->maxrank = 0;
        $return_obj->lastName = '';
        $return_obj->lastConnect = 0;
        $return_obj->stats = array();


        foreach ($this->getAll() as $server) {
            $player = $server->Players()->player($steam32);

            if ( $player ) {
                if ($player->getRank() > $return_obj->maxrank) $return_obj->maxrank = $player->getRank();

                if ($player->getLastconnect(true) > $return_obj->lastConnect) {
                    $return_obj->lastName = $player->getName();
                    $return_obj->lastConnect = $player->getLastconnect(true);
                }
            }
            $return_obj->stats[] = $player;
        }
        return $return_obj;
    }

    /**
     * @param int id
     * @return bool
     */
    public function delete($id)
    {
        if( isset($this->servers[$id]) ) {
            unset($this->servers[$id]);
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getGame()
    {
        return $this->gamelist;
    }
}
