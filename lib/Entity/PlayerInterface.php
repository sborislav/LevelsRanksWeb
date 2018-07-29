<?php

namespace LevelsRanks\Entity;

interface PlayerInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getValue();

    /**
     * @return string
     */
    public function getSteam();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return int
     */
    public function getRank();

    /**
     * @return int
     */
    public function getKills();

    /**
     * @return int
     */
    public function getDeaths();

    /**
     * @return int
     */
    public function getAssists();

    /**
     * @return int
     */
    public function getHeadshots();

    /**
     * @return int
     */
    public function getShoots();

    /**
     * @return int
     */
    public function getHits();

    /**
     * @return int
     */
    public function getHitsHead();

    /**
     * @return int
     */
    public function getHitsChest();

    /**
     * @return int
     */
    public function getHitsStomach();

    /**
     * @return int
     */
    public function getHitsArms();

    /**
     * @return int
     */
    public function getHitsLegs();

    /**
     * @return int
     */
    public function getLastconnect();
}