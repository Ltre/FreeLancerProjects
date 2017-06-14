<?php
@session_start();

$config = array(
    'app_id' => 'project-2nd',
);

$setting = array(
    "log.abc.com" => array(
        'debug' => 0,
        'rewrite' => array(
            'admin' => 'manage/index',
            'reportAdmin' => 'manage/reportAdmin',
            'report' => 'log/report',
            'login' => 'manage/login',
            '<c>/<a>' => '<c>/<a>',
        ),
        'mysql' => array(
            'MYSQL_HOST' => '127.0.0.1',
            'MYSQL_PORT' => '3306',
            'MYSQL_USER' => 'project-2nd',
            'MYSQL_DB'   => 'project-2nd',
            'MYSQL_PASS' => 'oaTx8H034ChsAj6k',
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    "project2-log.yooo.moe" => array(
        'debug' => 1,
        'rewrite' => array(
            'admin' => 'manage/index',
            'reportAdmin' => 'manage/reportAdmin',
            'report' => 'log/report',
            'login' => 'manage/login',
            '<c>/<a>' => '<c>/<a>',
        ),
        'mysql' => array(
            'MYSQL_HOST' => '127.0.0.1',
            'MYSQL_PORT' => '3306',
            'MYSQL_USER' => 'project-2nd',
            'MYSQL_DB'   => 'project-2nd',
            'MYSQL_PASS' => 'oaTx8H034ChsAj6k',
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    '127.0.0.1' => array(
        'debug' => 1,
        'rewrite' => array(),
        'mysql' => array(
            'MYSQL_HOST' => '127.0.0.1',
            'MYSQL_PORT' => '3306',
            'MYSQL_USER' => 'root',
            'MYSQL_DB'   => 'project-2nd',
            'MYSQL_PASS' => 'ltre',
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
);

define('DEBUG', $setting[$_SERVER["HTTP_HOST"]]["debug"]);
return $setting[$_SERVER["HTTP_HOST"]] + $config;