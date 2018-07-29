<?php

namespace LevelsRanks;

class Hits
{
    /**
     * @var int Всего попаданий
     */
    public $all;

    /**
     * @var int Попадаинй в голову
     */
    public $head = 0;

    /**
     * @var int Попаданий в грудь
     */
    public $chest = 0 ;

    /**
     * @var int Подадать в живот
     */
    public $stomach = 0;

    /**
     * @var int Попаданий в руки
     */

    public $arms = 0;
    /**
     * @var int Попаданий в ноги
     */
    public $legs = 0;

    public function __construct($value)
    {

        $value_array = explode(';', $value);
        array_pop($value_array);
        $i = 0;

        foreach (get_class_vars(__CLASS__) as $name => $value) {
            if ( !isset($value_array[$i]) )
                break;
            $this->$name = $value_array[$i];
            $i++;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->all;
    }

    /**
     * @return int
     */
    public function All()
    {
        return (int)$this->all;
    }
}