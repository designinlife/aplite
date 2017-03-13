<?php
$cfgs = array(
    'app'   => array(
        'timezone'        => 'Asia/Shanghai',
        'error_reporting' => E_ALL ^ E_NOTICE,
    ),
    'dbs'   => array(
        'default' => array(
            'host'    => '192.168.0.1',
            'port'    => 3306,
            'user'    => 'root',
            'pass'    => '11111111',
            'db'      => 'test',
            'charset' => 'utf8',
        ),
        'cross'   => array(
            'host'    => '192.168.0.2',
            'port'    => 3306,
            'user'    => 'root',
            'pass'    => '11111111',
            'db'      => 'test',
            'charset' => 'utf8',
        ),
    ),
    'sqs'   => array(
        'host' => '127.0.0.1',
        'port' => 11300,
    ),
    'cache' => array(
        'enable' => true,
        'type'   => 'redis',
        'host'   => '127.0.0.1',
        'port'   => 6379,
        'pass'   => '',
        'sock'   => '/tmp/redis.sock',
    ),
);