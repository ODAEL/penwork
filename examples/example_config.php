<?php

use Penwork\Config;

Config::getInstance()->setParams([
    'dir' => [
        'root' => dirname('/'), // Required
        'vendor' => dirname('/vendor'), // Required
        'views' => dirname('/views'), // Required
        'layouts' => dirname('/layouts'), // Required
    ],
    'error_pages' => [
        '404' => '/404.html',
    ],
    'layouts' => [
        'default' => '/layouts/default.php', // Required
    ],
    'db' => [
        'dsn' => '123', // Required
        'user' => '123', // Required
        'pass' => '123', // Required
        'query_logger' => null,
    ],
]);