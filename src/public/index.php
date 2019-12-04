<?php

require('../vendor/autoload.php');

use App\Bootstrap;
use App\Router;

$container = Bootstrap::buildContainer();

$router = (new Router())
    ->setDispatcher($container['dispatcher'])
    ->setLogger($container['logger'])
    ->setHandler($container['handler']);