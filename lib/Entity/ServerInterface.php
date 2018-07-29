<?php

namespace LevelsRanks\Entity;


interface ServerInterface
{
    /**
     * Create entity server
     * @param array $array
     */
    public function __construct( $array);

    /**
     * @return string Return name server
     */
    public function getName();
}