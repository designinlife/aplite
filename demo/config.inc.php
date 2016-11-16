<?php
$cfgs = array(
    'app' => array(
        'timezone'        => 'Asia/Shanghai',
        'error_reporting' => E_ALL ^ E_NOTICE,
    ),
    'dbs' => array(
        array(
            'host'    => '192.168.0.146',
            'port'    => 3306,
            'user'    => 'root',
            'pass'    => '11111111',
            'db'      => 'game_mx',
            'charset' => 'utf8',
        ),
        array(
            'host'    => '192.168.0.216',
            'port'    => 3306,
            'user'    => 'root',
            'pass'    => '11111111',
            'db'      => 'game_mx',
            'charset' => 'utf8',
        ),
    ),
);