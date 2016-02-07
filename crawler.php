#!/usr/bin/php
<?php

use \wolfram\App;
use \wolfram\Models\Crawler;
use \wolfram\Models\ServiceContainer;
use \wolfram\Models\Manager;
use \wolfram\Models\Reporter;


require __DIR__ . '/vendor/autoload.php';

$container = new ServiceContainer();

$container['crawler'] = function () {
    return new Crawler();
};

$container['reporter'] = function () {
    return new Reporter(__DIR__);
};

$container['manager'] = function() use ($container) {
    return new Manager($container->get('crawler'), $container->get('reporter'));
};


$app = new App($container);
$app->run();