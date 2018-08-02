<?php

namespace LevelsRanks;

class Hits
{
    /**
     * @var int Всего попаданий
     */
    public $all = 0;

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

    private $proVersion = false;

    public function __construct($value)
    {
        if ( !is_null($value) ) {
            $value_array = explode(';', $value);
            array_pop($value_array);
            $i = 0;

            if ( count($value_array)>1 ) {
                $this->proVersion = true;
                foreach (get_class_vars(__CLASS__) as $name => $value) {
                    if (!isset($value_array[$i]))
                        break;
                    $this->$name = (int)$value_array[$i];
                    $i++;
                }
            }else {
                $this->all = (int)$value_array[0];
            }
        }
    }

    public function isPro()
    {
        return $this->proVersion;
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