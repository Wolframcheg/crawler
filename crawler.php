#!/usr/bin/php
<?php

use \wolfram\App;
use \wolfram\Crawler;

require __DIR__ . '/vendor/autoload.php';

$container = new \wolfram\ServiceContainer();

$container['crawler'] = function () {
    return new Crawler();
};

//$container['html_filter'] = function () {
//    return new HtmlExtractor();
//};
//
$container['manager'] = function() use ($container) {
    return new \wolfram\Manager($container->get('crawler'));
};


$app = new App($container);
$app->run();