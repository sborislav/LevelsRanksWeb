<?php

namespace LevelsRanks\Entity;

use LevelsRanks\Core\Source;
use LevelsRanks\Players;

class Server extends Source implements ServerInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $gameid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $array;

    /**
     *
     * @var Players Работа с пользователями
     */
    private $playersOBJ;

    public function __construct($array)
    {
        $this->id = $array['id']; unset($array['id']);
        $this->gameid = $array['gameid']; unset($array['gameid']);
        $this->name = $array['name']; unset($array['name']);
        $this->table = $array['table']; unset($array['table']);
        if ( isset($array['playersOBJ']) ) unset($array['playersOBJ']);
        if ( isset($array['array']) ) $this->array = $array['array'];
        else $this->array = $array;

    }

    public function getConnect()
    {
        if (isset($this->array['connect']))
            return $this->array['connect'];
        return $this->array;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getGameId()
    {
        return $this->gameid;
    }

    public function getGameNameSlim()
    {
        $arr = array(
            240 => 'csource',
            730 => 'csgo',
        );
        return $arr[$this->gameid];
    }

    public function getGameName()
    {

        $arr = array(
            240 => 'Counter-Strike: Source',
            730 => 'Counter-Strike: Global Offensive',
        );
        return $arr[$this->gameid];
    }

    /**
     * @return Players
     *
     */
    public function Players()
    {
        return $this->playersOBJ ? $this->playersOBJ : $this->playersOBJ = new Players( $this->id, $this->table );
    }

    public function Update($sql = '')
    {
        if (!empty($sql)) {
            $sql = str_replace('{table}', $this->table, $sql);
            return (bool)static::$connect[$this->id]->get()->exec($sql);
        }
        return false;
    }

    /**
     * Получение сигнатуры БД для определения версии
     */
    public function SigBD()
    {
        $sig_query = static::$connect[$this->id]->get()->query('SHOW COLUMNS FROM '.$this->table);
        $for_hash = '';

        foreach ($sig_query as $row) {
            $for_hash .= $row['Field'] . '^o{8e-1';
        }
        return hash('md5', $for_hash);
    }

    public static function __set_state($an_array) // С PHP 5.1.0
    {
        $obj = new Server($an_array);
        return $obj;
    }

}
