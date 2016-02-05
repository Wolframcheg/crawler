#!/usr/bin/php
<?php

use \wolfram\App;
use \wolfram\Models\Crawler;
use \wolfram\Models\ServiceContainer;
use \wolfram\Models\Manager;


require __DIR__ . '/vendor/autoload.php';

$container = new ServiceContainer();

$container['crawler'] = function () {
    return new Crawler();
};

//$container['html_filter'] = function () {
//    return new HtmlExtractor();
//};
//
$container['manager'] = function() use ($container) {
    return new Manager($container->get('crawler'));
};


$app = new App($container);
$app->run();