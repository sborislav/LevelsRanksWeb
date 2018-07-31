<?php

namespace LevelsRanks\Core;

class Weapons
{
    public $all= 0;   // все оружия

    public $knife= 0;                // Нож
    public $taser= 0;                // Зевс x27
    public $inferno= 0;                // Молотов
    public $hegrenade= 0;            // Граната
    public $glock= 0;                // Glock
    public $hkp2000= 0;            // P2000
    public $tec9= 0;                // Tec-9
    public $usp_silencer= 0;        // USP-S
    public $p250= 0;                // P250
    public $cz75a= 0;                // CZ-75a

    public $fiveseven= 0;                // Five Seven
    public $elite= 0;                    // Dual Berettas
    public $revolver= 0;                // Revolver
    public $deagle= 0;                    // Desert Eagle
    public $negev= 0;                    // Negev
    public $m249= 0;                    // M249
    public $mag7= 0;                    // Mag-7
    public $sawedoff= 0;                // Sawedoff
    public $nova= 0;                    // Nova
    public $xm1014= 0;                // XM1014

    public $bizon= 0;                // Bizon
    public $mac10= 0;                // MAC-10
    public $ump45= 0;            // UMP-45
    public $mp9= 0;                // MP9
    public $mp7= 0;                // MP7
    public $p90= 0;                // P90
    public $galilar= 0;                // Galil AR
    public $famas= 0;                // Famas
    public $ak47= 0;                // AK-47
    public $m4a4= 0;                // M4A4

    public $m4a1_silencer= 0;            // M4A1-s
    public $aug= 0;                    // AUG
    public $sg556= 0;                    // SG-553
    public $ssg08= 0;                    // SSG-08 (Scout)
    public $awp= 0;                    // AWP
    public $scar20= 0;                    // SCAR-20
    public $g3sg1= 0;                    // G3SG1
    public $usp= 0;                    // KM .45 Tactical  (только для CS:Source)
    public $p228= 0;                    // 228 Compact (только для CS:Source)
    public $m3= 0;                    // Leone 12 Gauge Super (только для CS:Source)

    public $tmp= 0;                    // Schmidt Machine Pistol (только для CS:Source)
    public $mp5navy= 0;                // KM Sub-Machine Gun (только для CS:Source)
    public $galil= 0;                    // IDF Defender (только для CS:Source)
    public $scout= 0;                    // Schmidt Scout (только для CS:Source)
    public $sg550= 0;                    // Krieg 550 Commando (только для CS:Source)
    public $sg552= 0;                    // Krieg 552 (только для CS:Source)


    private static $GAME_CSS  = 0;
    private static $GAME_CSGO = 1;
    private        $game      = null;

    private static $WEAPON_All           = 0;
    private static $WEAPON_Melee         = 1;
    private static $WEAPON_Grenades      = 2;
    private static $WEAPON_Pistols       = 3;
    private static $WEAPON_ShotGuns      = 4;
    private static $WEAPON_SubmachineGun = 5;
    private static $WEAPON_AssaultRifle  = 6;
    private static $WEAPON_SniperRifle   = 7;
    private static $WEAPON_MachineGuns   = 8;
    private        $weapon_group         = null;
    private $proVersion = false;

    private $array = array(
        'knife' => [
            'name' => 'Нож',
            'icon' => 'knife.png',
            'img'  => 'knife.png'
        ],
        'taser' => [
            'name' => 'Zeus x27',
            'icon' => 'Zeus_x270.png',
            'img'  => 'zeus.png'
        ],
        'inferno' => [
            'name' => 'Коктейль Молотова',
            'icon' => 'molotov.png',
            'img'  => 'molotov.png'
        ],
        'hegrenade' => [
            'name' => 'Осколочная граната',
            'icon' => 'he.png',
            'img'  => 'he.png'
        ],

        'glock' => [
            'name' => 'Glock-18',
            'icon' => 'glock.png',
            'img'  => 'glock.png'
        ],
        'hkp2000' => [
            'name' => 'P2000',
            'icon' => 'p20000.png',
            'img'  => 'glock.png'
        ],
        'tec9' => [
            'name' => 'Tec-9',
            'icon' => 'tec9.png',
            'img'  => 'tec9.png'
        ],
        'usp_silencer' => [
            'name' => 'USP-S',
            'icon' => 'usps.png',
            'img'  => 'usps.png'
        ],
        'p250' => [
            'name' => 'P250',
            'icon' => 'p250.png',
            'img'  => 'p250.png'
        ],
        'cz75a' => [
            'name' => 'CZ75-Auto',
            'icon' => 'cz75a.png',
            'img'  => 'cz75a.png'
        ],
        'fiveseven' => [
            'name' => 'Five-SeveN',
            'icon' => 'fiveseven.png',
            'img'  => 'fiveseven.png'
        ],
        'elite' => [
            'name' => 'Беретты',
            'icon' => 'elite.png',
            'img'  => 'elite.png'
        ],
        'revolver' => [
            'name' => 'Револьвер R8',
            'icon' => 'revolver.png',
            'img'  => 'revolver.png'
        ],
        'deagle' => [
            'name' => 'Desert Eagle',
            'icon' => 'deagle.png',
            'img'  => 'deagle.png'
        ],

        'm249' => [
            'name' => 'M249',
            'icon' => 'm249.png',
            'img'  => 'm249.png'
        ],
        'negev' => [
            'name' => 'Negev',
            'icon' => 'negev.png',
            'img'  => 'negev.png'
        ],

        'mag7'  => [
            'name' => 'MAG-7',
            'icon' => 'mag7.png',
            'img'  => 'mag7.png'
        ],
        'sawedoff' => [
            'name' => 'Sawed-Off',
            'icon' => 'sawedoff.png',
            'img'  => 'sawedoff.png'
        ],
        'nova' => [
            'name' => 'Nova',
            'icon' => 'nova.png',
            'img'  => 'nova.png'
        ],
        'xm1014' => [
            'name' => 'XM1014',
            'icon' => 'xm1014.png',
            'img'  => 'xm1014.png'
        ],

        'bizon' => [
            'name' => 'ПП-19 Бизон',
            'icon' => 'bizon.png',
            'img'  => 'bizon.png'
        ],
        'mac10' => [
            'name' => 'MAC-10',
            'icon' => 'mac10.png',
            'img'  => 'mac10.png'
        ],
        'ump45' => [
            'name' => 'UMP-45',
            'icon' => 'ump45.png',
            'img'  => 'ump45.png'
        ],
        'mp9' => [
            'name' => 'MP9',
            'icon' => 'mp9.png',
            'img'  => 'mp9.png'
        ],
        'mp7' => [
            'name' => 'MP7',
            'icon' => 'mp7.png',
            'img'  => 'mp7.png'
        ],
        'p90' => [
            'name' => 'P90',
            'icon' => 'p90.png',
            'img'  => 'p90.png'
        ],

        'galilar' => [
            'name' => 'Galil AR',
            'icon' => 'galilar.png',
            'img'  => 'galilar.png'
        ],
        'famas' => [
            'name' => 'FAMAS',
            'icon' => 'famas.png',
            'img'  => 'famas.png'
        ],
        'ak47' => [
            'name' => 'AK-47',
            'icon' => 'ak47.png',
            'img'  => 'ak47.png'
        ],
        'm4a4'=> [
            'name' => 'M4A4',
            'icon' => 'm4a4.png',
            'img'  => 'm4a4.png'
        ],
        'm4a1_silencer'=> [
            'name' => 'M4A1-S',
            'icon' => 'm4a1.png',
            'img'  => 'm4a1.png'
        ],
        'aug' => [
            'name' => 'AUG',
            'icon' => 'aug.png',
            'img'  => 'aug.png'
        ],
        'sg556' => [
            'name' => 'SG 553',
            'icon' => 'sg556.png',
            'img'  => 'sg556.png'
        ],

        'ssg08' => [
            'name' => 'SSG 08',
            'icon' => 'ssg08.png',
            'img'  => 'ssg08.png'
        ],
        'awp' => [
            'name' => 'AWP',
            'icon' => 'awp.png',
            'img'  => 'awp.png'
        ],
        'scar20' => [
            'name' => 'SCAR-20',
            'icon' => 'scar20.png',
            'img'  => 'scar20.png'
        ],
        'g3sg1'=> [
            'name' => 'G3SG1',
            'icon' => 'g3sg1.png',
            'img'  => 'g3sg1.png'
        ],

        'usp' => [
            'name' => 'KM .45 Tactical',
            'icon' => 'usp_css.png',
        ],
        'p228' => [
            'name' => '228 Compact',
            'icon' => 'p228_css.png',
        ],
        'tmp' => [
            'name' => 'Schmidt Machine Pistol',
            'icon' => 'tmp_css.png',
        ],
        'mp5navy' => [
            'name' => 'KM Sub-Machine Gun',
            'icon' => 'mp5_css.png',
        ],
        'galil' => [
            'name' => 'IDF Defender',
            'icon' => 'galil_css.png',
        ],
        'scout' => [
            'name' => 'Schmidt Scout',
            'icon' => 'scout_css.png',
        ],
        'sg550' => [
            'name' => 'Krieg 550 Commando',
            'icon' => 'sg550_css.png',
        ],
        'sg552' => [
            'name' => 'Krieg 552',
            'icon' => 'sg552_css.png',
        ]
    );

    /**
     * @var int Необходимость преобразовывать данные к виду массива
     */
    private $_needArray = 0;

    public function __construct($value, $game = null)
    {
        if ( !is_null($value) ) {
            $this->weapon_group = self::$WEAPON_All;
            $this->game = self::$GAME_CSGO;

            $value_array = explode(';', $value);
            array_pop($value_array);
            $i = 0;

            if ( count($value_array)>1 ){
                $this->proVersion = true;
                foreach (get_class_vars(__CLASS__) as $name => $value) {
                    if (!isset($value_array[$i]))
                        break;
                    $this->$name = (int)$value_array[$i];
                    $i++;
                }

                if (!empty($game)) {
                    if (!$this->setGame($game))
                        throw new \Exception('Игра не найдена');
                }
            } else {
                $this->all = (int)$value_array[$i];
            }
        }
    }

    public function isPro()
    {
        return $this->proVersion;
    }

    /**
     * @param $game int|string
     * @return bool
     */
    public function setGame($game)
    {
        if ( empty($game) )
            return false;

        if (is_numeric($game)) {
            switch ($game){
                case 240: $this->game = self::$GAME_CSS; return true;
                case 730: $this->game = self::$GAME_CSGO; return true;
            }
        }
        switch ($game){
            case 'csource': $this->game = self::$GAME_CSS; return true;
            case 'css': $this->game = self::$GAME_CSS; return true;
            case 'csso': $this->game = self::$GAME_CSGO; return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->all;
    }

    /**
     * @param $function string Название функии класса оружия
     * @param $top
     * @return array
     */
    private function subFunctionArray($top = false)
    {
        $this->_needArray = 1;
        $new_array = array();

        switch ($this->game){
            case self::$GAME_CSS:  $array = $this->gameCSS(); break;
            case self::$GAME_CSGO: $array = $this->gameCSGO();break;
        }

        if ($top) {
            arsort($array);
        }

        foreach ($array as $name => $value) {

            $tem_arr = array();
            if ( is_array($this->array[$name]) ) {
                $tem_arr = $this->array[$name];
            } else {
                $tem_arr['name'] = $this->array[$name];
            }
            $tem_arr['value'] = $value;
            $new_array[] = $tem_arr;
        }
        $this->_needArray = 0;
        return $new_array;
    }

    /**
     * @return int
     */
    public function All()
    {
        return $this->all;
    }

    /**
     * Список групп оружия, необходимый для дальнейщего развития
     * @return array
     */
    public function GroupName()
    {
        return [
            self::$WEAPON_Melee => 'Орижие ближнего боя',
            self::$WEAPON_Pistols => 'Пистолеты',
            self::$WEAPON_ShotGuns => 'Дробовики',
            self::$WEAPON_SubmachineGun => 'Пистолеты-Пулеметы',
            self::$WEAPON_AssaultRifle => 'Автоматы',
            self::$WEAPON_SniperRifle => 'Снайперские винтовки',
            self::$WEAPON_MachineGuns => 'Пулеметы',
            self::$WEAPON_Grenades => 'Гранаты'
        ];
    }


    public function getWeapons($array = false, $weapon = 0, $top = false)
    {
        if ( is_int($array) ) {
            $tmp = $weapon;
            $weapon = $array;
            $array = $tmp;
        }

        if ( is_bool($weapon) ){
            $tmp = $top;
            $top = $weapon;
            $weapon = (int)$tmp;
        }


        if (is_int($weapon) && $weapon >= 0 && $weapon <=8 )
            $this->weapon_group = $weapon;

        if ($array) {
            return $this->subFunctionArray($top);
        } else {
            switch ($this->game){
                case self::$GAME_CSS:  return $this->gameCSS();
                case self::$GAME_CSGO: return $this->gameCSGO();
            }
        }
        return $this->All();
    }

    /**
     * @return \stdClass
     */
    public function gameCSS()
    {
        $obj = new \stdClass();
        if ($this->weapon_group == self::$WEAPON_Melee || $this->weapon_group == self::$WEAPON_All) {
            $obj->knife = $this->knife;
        }
        if ($this->weapon_group == self::$WEAPON_Grenades || $this->weapon_group == self::$WEAPON_All) {
            $obj->hegrenade = $this->hegrenade;
        }
        if ($this->weapon_group == self::$WEAPON_Pistols || $this->weapon_group == self::$WEAPON_All) {
            $obj->glock     = $this->glock;
            $obj->usp       = $this->usp;
            $obj->p228      = $this->p228;
            $obj->deagle    = $this->deagle;
            $obj->elite     = $this->elite;
            $obj->fiveseven = $this->fiveseven;
        }
        if ($this->weapon_group == self::$WEAPON_MachineGuns || $this->weapon_group == self::$WEAPON_All) {
            $obj->m3     = $this->m3;
            $obj->xm1014 = $this->xm1014;
        }
        if ($this->weapon_group == self::$WEAPON_SubmachineGun || $this->weapon_group == self::$WEAPON_All) {
            $obj->mac10   = $this->mac10;
            $obj->tmp     = $this->tmp;
            $obj->mp5navy = $this->mp5navy;
            $obj->ump45   = $this->ump45;
            $obj->p90     = $this->p90;
        }
        if ($this->weapon_group == self::$WEAPON_AssaultRifle || $this->weapon_group == self::$WEAPON_All) {
            $obj->galil = $this->galil;
            $obj->famas = $this->famas;
            $obj->ak47  = $this->ak47;
            $obj->m4a1  = $this->m4a4;
            $obj->aug   = $this->aug;
            $obj->sg550 = $this->sg550;
        }
        if ($this->weapon_group == self::$WEAPON_SniperRifle || $this->weapon_group == self::$WEAPON_All) {
            $obj->scout = $this->scout;
            $obj->awp   = $this->awp;
            $obj->g3sg1 = $this->g3sg1;
            $obj->sg552 = $this->sg552;
        }
        if ($this->weapon_group == self::$WEAPON_MachineGuns || $this->weapon_group == self::$WEAPON_All) {
            $obj->m249 = $this->m249;
        }
        if ($this->_needArray)
            $obj = (array)$obj;
        return $obj;
    }

    /**
     * @return \stdClass
     */
    public function gameCSGO()
    {
        $obj = new \stdClass();
        if ($this->weapon_group == self::$WEAPON_Melee || $this->weapon_group == self::$WEAPON_All) {
            $obj->knife = $this->knife;
            $obj->taser = $this->taser;
        }
        if ($this->weapon_group == self::$WEAPON_Grenades || $this->weapon_group == self::$WEAPON_All) {
            $obj->inferno   = $this->inferno;
            $obj->hegrenade = $this->hegrenade;
        }
        if ($this->weapon_group == self::$WEAPON_Pistols || $this->weapon_group == self::$WEAPON_All) {
            $obj->glock         = $this->glock;
            $obj->hkp2000       = $this->hkp2000;
            $obj->tec9          = $this->tec9;
            $obj->usp_silencer  = $this->usp_silencer;
            $obj->p250          = $this->p250;
            $obj->cz75a         = $this->cz75a;
            $obj->fiveseven     = $this->fiveseven;
            $obj->elite         = $this->elite;
            $obj->revolver      = $this->revolver;
            $obj->deagle        = $this->deagle;
        }
        if ($this->weapon_group == self::$WEAPON_MachineGuns || $this->weapon_group == self::$WEAPON_All) {
            $obj->negev = $this->negev;
            $obj->m249  = $this->m249;
        }
        if ($this->weapon_group == self::$WEAPON_ShotGuns || $this->weapon_group == self::$WEAPON_All) {
            $obj->mag7      = $this->mag7;
            $obj->sawedoff  = $this->sawedoff;
            $obj->nova      = $this->nova;
            $obj->xm1014    = $this->xm1014;
        }
        if ($this->weapon_group == self::$WEAPON_SubmachineGun || $this->weapon_group == self::$WEAPON_All) {
            $obj->bizon = $this->bizon;
            $obj->mac10 = $this->mac10;
            $obj->ump45 = $this->ump45;
            $obj->mp9   = $this->mp9;
            $obj->mp7   = $this->mp7;
            $obj->p90   = $this->p90;
        }
        if ($this->weapon_group == self::$WEAPON_AssaultRifle || $this->weapon_group == self::$WEAPON_All) {
            $obj->galilar       = $this->galilar;
            $obj->famas         = $this->famas;
            $obj->ak47          = $this->ak47;
            $obj->m4a4          = $this->m4a4;
            $obj->m4a1_silencer = $this->m4a1_silencer;
            $obj->aug           = $this->aug;
            $obj->sg556         = $this->sg556;
        }
        if ($this->weapon_group == self::$WEAPON_SniperRifle || $this->weapon_group == self::$WEAPON_All) {
            $obj->ssg08  = $this->ssg08;
            $obj->awp    = $this->awp;
            $obj->scar20 = $this->scar20;
            $obj->g3sg1  = $this->g3sg1;
        }
        if ($this->_needArray)
            $obj = (array)$obj;
        return $obj;
    }
}
