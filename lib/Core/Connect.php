<?php

namespace LevelsRanks\Core;

use PDO;

class Connect
{
    private $connect;

    /**
     * @var string
     */
    private $dsn, $user, $password;

    public function __construct($array)
    {
        $this->dsn = $array['dsn'];
        $this->user = $array['user'];
        $this->password = $array['pass'];
    }


    private function set()
    {
        return $this->connect = new PDO($this->dsn,$this->user, $this->password, array(
            PDO::ATTR_PERSISTENT => true,
        ));
    }


    public function get()
    {
        return $this->connect ? $this->connect : $this->set();
    }

}