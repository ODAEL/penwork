<?php

use Penwork\Config;

Config::getInstance()->setParams([
    'path' => [
        'root' => dirname('/'), // Required
        'vendor' => dirname('/vendor'), // Required
        'controllers' => dirname('/controllers'), // Required
        'views' => dirname('/views'), // Required
        'layouts' => dirname('/layouts'), // Required
    ],
    'namespace' => [
        'controller' => 'App\\Controller'
    ],
    'error_page' => [
        '404' => '/404.html',
    ],
    'layout' => [
        'default' => '/layouts/default.php', // Required
    ],
    'db' => [
        'dsn' => '123', // Required
        'user' => '123', // Required
        'pass' => '123', // Required
        'query_logger' => null,
    ],
]);