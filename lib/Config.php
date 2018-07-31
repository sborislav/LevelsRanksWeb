<?php

namespace LevelsRanks;

use LevelsRanks\Exception\CacheCreateFail;

class Config
{
    /**
     * @var array
     */
    private $configs = [
        'system' => 2432,  // системная информация необходимая для определения версии вашего LR
        'version' => '2.4.3  for SB MaterialAdmin',
        'recordOnPage' =>  50,
        'icon_id' => 20,
        'signature' => false,
        'displayScore' => false,
        'displayFreeServer' => false,
        'steamStats' => true,
        'formatKDA' => true,
        'resetRank' => true,
        'typeStats' => false,
        'formatDate' => true,
        'cacheSteamAva' => true,
        'cacheSteamAvaTime' => 604800,
        'CACHE' => false,
        'CACHETIME' => 86400,
        'CACHE_SIG' => true,
        'CACHETIME_SIG' => 3600,
    ];


    public function __construct()
    {
        $this->getConfigs();
    }

    private function getConfigs()
    {
        if ( file_exists(__DIR__.'/Cache/config.php') ) {
            $this->configs = array_merge($this->configs, include __DIR__.'/Cache/config.php');
        }
    }

    /**
     * @return $this
     * @throws CacheCreateFail
     */
    public function save()
    {
        $string = "<?php\n return ".var_export($this->configs, true).';';
        if ( file_put_contents(__DIR__.'/Cache/config.php', $string) === false )
            throw new CacheCreateFail("Ошибка: не удается создать кеш конфигов");
        return $this;
    }

    /**
     * @param $name
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function __set( $name, $value )
    {
        if ( isset($this->configs[$name]) ){
            if ( is_int($this->configs[$name]) )
                $value = (int)$value;
            elseif ( is_bool($this->configs[$name]) )
                $value = (bool)$value;
            $this->configs[$name] = $value;
        } else
            throw new \Exception("Переменая $name не найдена");
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if (isset($this->configs[$name])) {
            return $this->configs[$name];
        } else
            throw new \Exception("Переменая $name не найдена");
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function add($name, $value)
    {
        if ( !isset($this->configs[$name]) )
            $this->configs[$name] = $value;
    }

    public function has($name)
    {
        return isset($this->configs[$name]);
    }
}
