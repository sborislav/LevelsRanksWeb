<?php

namespace LevelsRanks;

use LevelsRanks\Exception\CacheCreateFail;

/**
 * Class для работы с аватарками пользователей
 * Для кеша необходимо наличие папки в корне /images/levelsranks/cache
 * @package LevelsRanks
 */
class Avatars
{
    private $avatars;

    public function add( $steam, $avatar )
    {
        $this->avatars[$steam]=array($avatar, time());
    }

    /**
     * @return $this
     * @throws CacheCreateFail
     */
    public function save()
    {
        $string = "<?php\n return ".var_export($this->avatars, true).';';
        if ( file_put_contents(__DIR__.'/Cache/avatars.php', $string) === false )
            throw new CacheCreateFail("Ошибка: не удается создать кеш аваторок");
        return $this;
    }

    public function has($steam)
    {
        if ( empty($this->avatars) )
            $this->getAll();
        return (isset($this->avatars[$steam]) && ($this->avatars[$steam][1] + LevelsRanks::$config->cacheSteamAvaTime > time()) );
    }

    public function get($steam)
    {
         return $this->avatars[$steam][0];
    }

    public function set($steam, $avatar)
    {
        $this->add( $steam, $avatar );
    }

    public function getAll()
    {
        if ( file_exists(__DIR__.'/Cache/avatars.php') ) {
            $this->avatars = include __DIR__.'/Cache/avatars.php';
        }
        return $this->avatars;
    }

    public function steam($data)
    {
        /**
         * Если включен кеш аватарок
         */
        if ( LevelsRanks::$config->cacheSteamAva )
            $this->getAll();

        $returnData = [];
        // Сервера

        foreach ($data as $id=>$server) {
            $dataStr = "";
            // Формирование строки запроса

            foreach ($server as $value) {

                $cacheFile = LevelsRanks::$ROOT_DIR."images/levelsranks/cache/$value.jpg";

                if ( LevelsRanks::$config->CACHE && (file_exists($cacheFile) && (time() - LevelsRanks::$config->CACHETIME) < filemtime($cacheFile))) {
                    $returnData[$id][] = ["id" => $value, "url" => "images/levelsranks/cache/$value.jpg"];
                } else {
                    $dataStr .= $value.",";
                    $this->add($value, "images/levelsranks/noname.png");
                    $returnData[$id][] = ["id" => $value, "url" => "images/levelsranks/noname.png"];
                }
            }

            $json2 = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".LevelsRanks::$STEAM_API."&steamids=$dataStr"));
            foreach ($json2->response->players as $value) {
                if ( PHP_VERSION >= 5.5 )
                    $search_id = array_search($value->steamid, array_column($returnData[$id], 'id'));
                else{
                    $search_id = 0;
                    foreach ($returnData[$id] as $row){
                        if ( $value->steamid == $row['id']) break;
                        $search_id++;
                    }
                }

                $this->set($value->steamid, $value->avatar);
                $returnData[$id][$search_id] = ["id" => $value->steamid, "url" => $value->avatar];

                $cacheFile = LevelsRanks::$ROOT_DIR."images/levelsranks/cache/{$value->steamid}.jpg";

                if ( LevelsRanks::$config->CACHE ) {
                    if (file_put_contents($cacheFile, file_get_contents($value->avatar))) {
                        $this->set($value->steamid, "images/levelsranks/cache/{$value->steamid}.jpg");
                    }
                }
            }
        }
        if ( LevelsRanks::$config->cacheSteamAva )
            $this->save();
        return $returnData;
    }

}