# LevelsRanksWeb

WEB библиотека для плагина Levels Ranks [![HLmod](https://dev.sborislav.xyz/lr240/hlmod.png)](https://hlmod.ru/resources/177/)
## Установка

    include "bootstrap.php";
    $lr = new LevelsRanks($steam_api, $site_root);
*$site_root - необходим для получения расположения картинок, которые должны быть в /images/levelsranks/*
### Добавление сервера

    $lr = new LevelsRanks\Server();
    $lr
	    ->add($name, $bd, $user = 'root', $pass = '', $host = '127.0.0.1', $table = 'lvl_base', $game = null, $port = 3306, $charset = "UTF8")
	    ->save();
или

    $lr = new LevelsRanks();
    $lr->Server()
	    ->add($name, $bd, $user = 'root', $pass = '', $host = '127.0.0.1', $table = 'lvl_base', $game = 240, $port = 3306, $charset = "UTF8")
	    ->save();
 добавление сервера в уже существуюущую базу

    $lr->Server()
	    ->add($name, $connectID, $table = 'lvl_base', $game = 240)
	    ->save();
### Получение информации

    $lr = new LevelsRanks();
    foreach ($lr->Server()->getAll() as $server) {
	    echo $server->name."\n";
	    echo $server->getGameName()."\n";
	    echo "Игроков в статистике: "$server->Players()->count();
    }
  
 TOP игроки:
 

    foreach ($server->Players()->top() as $player) {
	    echo "Игрок: {$player->getName()} убийств: {$player->getKills()} смертей {$player->getDeaths()}\n";
    }
Игроки с одного сервера:

    $server->Players()->page($page = 0);
	
 Более подробная информация в файлах 
 

 - lib/Server.php
 - lib/Players.php
 - lib/Entity/Server.php
 - lib/Entity/Player.php

### Получение информации об одном игроке

    $lr = new LevelsRanks();
    $player = $lr->Player($steam);
    echo $player->maxrank."\n";
    echo $player->lastName."\n";
    foreach ( $player->stats as $playerOnSevers) {
		echo 'Очки: {$playerOnSevers->getValue()}\n";
	    echo 'Убийств: {$playerOnSevers->getKills()}\n";
	    echo 'Смертей: {$playerOnSevers->getDeaths()}\n";
    }
## Работа с конфигами

    $lr_config = new LevelsRanks\Config();
    $lr_config->add($name, $value)->save();
    $lr_config->$name = $value;
    echo $lr_config->$name;
   

    echo LevelsRanks::Config()->$name;
    LevelsRanks::Config()->$name = $value;
    LevelsRanks::Config()->add($name, $value)->save();
Функиця add необходима для новых параметров, если вы попытаетесь установить или получить несуществующий параметр, то получите исключение.
## Работа с аватарками Steam-профилей

    $lr = new \LevelsRanks\LevelsRanks($steam_api);
    var_dump($avatar->steam($data));
    
 $data - список steamID64 игроков для каждого сервера, если сервер всего 1, то все равно должен быть двумерный массив с индексом 0.

    $data = array(
	    0 => [
		    steam64,
		    steam64,
		    steam64,
	    ],
	    1 => [
		    steam64,
		    steam64,
		    steam64,
	    ],
    );
## Создание дополнительных проверкок на "бан", "mute"...
- Выполение проверки
- Получение списка игроков или игрока
- Перебор массива с использованием ссылки на **&**$player и проверка его steam_id или другого параметра
- Если условие выполнилось то `$player->*дополнительный параметр* = *значение*`
