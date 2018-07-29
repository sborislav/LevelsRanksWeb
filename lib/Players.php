<?php

namespace LevelsRanks;

use LevelsRanks\Core\Source;
use LevelsRanks\Entity\Player;
use LevelsRanks\Exception\FailConnect;
use PDO;

class Players extends Source
{

    private $id ;
    private $table;


    public function __construct( $id, $table )
    {
        $this->table = $table;
        $this->id = $id;
    }

    /**
     * Количество игроков на сервере
     *
     * @return int
     * @throws FailConnect
     */
    public function count()
    {

        $stmt = static::$connect[$this->id]->get()->query('SELECT COUNT(*) as count FROM `'.$this->table.'`');

        if ( $stmt === false )
            throw new FailConnect("Таблица $this->table не существует");

       return $stmt->fetchColumn();
    }

    /**
     * @return string
     * @throws FailConnect
     */
    public function __toString()
    {
        return $this->count();
    }


    /**
     * Топ игроки на этом сервере
     * @return array
     */
    public function top()
    {
        return static::$connect[$this->id]->get()->query('SELECT * FROM `'.$this->table.'` ORDER BY value DESC LIMIT 10')->fetchAll(PDO::FETCH_CLASS, 'LevelsRanks\Entity\Player');
    }

    /**
     * Игроки на этой странице
     * @param $page
     * @return array
     */
    public function page($page)
    {
        $stmt = static::$connect[$this->id]->get()->prepare('SELECT * FROM `'.$this->table.'` ORDER BY value DESC LIMIT :page, :recordOnPage');
        $stmt->bindValue(':page', $page, PDO::PARAM_INT);
        $stmt->bindValue(':recordOnPage', LevelsRanks::$config->recordOnPage, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'LevelsRanks\Entity\Player');
    }

    /**
     * @param $steam32
     * @return Player
     */
    public function player($steam32)
    {
        $stmt = static::$connect[$this->id]->get()->prepare('SELECT * FROM `'.$this->table.'` WHERE steam LIKE :steam');
        $stmt->execute(['steam' => "%$steam32"]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'LevelsRanks\Entity\Player');
        return $stmt->fetch();
    }

    /**
     * Сбросить статистику
     * @param $steam32
     * @return bool
     */
    public function reset($steam32)
    {
        $steam = LevelsRanks::SteamConvert($steam32);
        if (!$steam)
            return false;

        $value = 0;
        if ( LevelsRanks::$config->typeStats )
            $value = 1000;

        $stmt = static::$connect[$this->id]->get()->prepare('UPDATE `'.$this->table.'` SET `value` = :value, `rank` = NULL, `kills` = NULL, `deaths` = NULL, `shoots` = NULL, `hits` = NULL, `headshots` = NULL, `assists` = NULL, `round_win` = NULL, `round_lose` = NULL WHERE `steam` LIKE :steam');
        return $stmt->execute(['value' => $value,'steam'=> "%$steam%" ]);
    }

    /**
     * Поиск игроков по стиму или нику
     * @param $data
     * @param $method
     * @return array
     */
    public function searchPlayer($data, $method)
    {
        if($method == "steam"){
            $steam = LevelsRanks::SteamConvert($data);
            if ($steam) {
                $stmt = static::$connect[$this->id]->get()->prepare('SELECT * FROM `'.$this->table.'` WHERE steam LIKE ? ORDER BY value DESC LIMIT 10');
                $stmt->execute(["%$steam"]);
                return $stmt->fetchAll(PDO::FETCH_CLASS, 'LevelsRanks\Entity\Player');
            }

        }else{
            $stmt = static::$connect[$this->id]->get()->prepare('SELECT * FROM `'.$this->table.'` WHERE name LIKE ? ORDER BY value DESC LIMIT 10');
            $stmt->execute(["%$data%"]);
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'LevelsRanks\Entity\Player');
        }
        return array();
    }
}
