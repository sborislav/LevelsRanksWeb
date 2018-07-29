<?php

namespace LevelsRanks\Game;

class game730 extends Game
{
    protected $id = 730;
    protected $name = 'Counter-Strike: Global Offensive';
    protected $smallname = 'csgo';

    protected $array = [
        'total_kills'               => 'kill',
        'total_deaths'              => 'death',
        'total_time_played'         => 'time',
        'total_planted_bombs'       => 'bombPlanted',
        'total_defused_bombs'       => 'bombDefused',
        'total_wins'                => 'win',
        'total_damage_done'         => 'damage',
        'total_money_earned'        => 'money',
        'total_dominations'         => 'domination',
        'total_revenges'            => 'revenge',
        'total_shots_hit'           => 'hit',
        'total_shots_fired'         => 'shot',
        'total_kills_headshot'      => 'headshot',
        'total_kills_enemy_blinded' => 'killsBlinded',
        'total_kills_knife_fight'   => 'winsKnifeFight',
        'total_kills_enemy_weapon'  => 'killsEnemyWeapons',
        'total_wins_pistolround'    => 'winPistolRound',
    ];
}