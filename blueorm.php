#!/usr/bin/env php
<?php declare(strict_types=1);

use DavidMorenoCortina\ORM\CommandLineUI\CommandLine;

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

foreach (array(__DIR__ . '/../../../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        if(!defined('BLUEORM_ROOT')) {
            DEFINE('BLUEORM_ROOT', str_replace('vendor/autoload.php', '', $file));
        }

        require $file;

        break;
    }
}

if(!file_exists(BLUEORM_ROOT . 'blueorm-settings.php')) {

    $data = [
        'db' => [
            'host' => '',
            'port' => 3306,
            'dbName' => '',
            'user' => '',
            'password' => ''
        ]
    ];

    file_put_contents(BLUEORM_ROOT . 'blueorm-settings.php', '<?php return ' . var_export($data, true) . ';');
    echo 'Settings for this console command must be configured' . "\r\n";
    die();
}

$settings = require BLUEORM_ROOT . 'blueorm-settings.php';

$dsn = 'mysql:host=' . $settings['db']['host'] . ';port=' . $settings['db']['port'] . ';dbname=' . $settings['db']['dbName'];
try {
    $connection = new PDO($dsn, $settings['db']['user'], $settings['db']['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']);
}catch (PDOException $e){
    echo 'Settings for this console command must be configured' . "\r\n";
    die();
}
$commandLine = new CommandLine();

$commandLine->run($_SERVER['argv'], $connection);