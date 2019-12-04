<?php

namespace App;

use Pimple\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Bootstrap
{
    /**
     * Create and return the container interface
     * @return Container
     */
    public static function buildContainer(): Container
    {
        // construct DI container
        $container = new Container();

        $container['logger'] = function () {
            $logger = new Logger('my_logger');
            $logger->pushHandler(new StreamHandler(__DIR__.'/../log/' . date('Y-m-d') . '.log', Logger::DEBUG));
            return $logger;
        };

        $container['dispatcher'] = function() {
            return \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
                $r->addRoute('GET', '/', 'home');
            });
        };

        $container['controller'] = function($container) {
            return (new Controller())
                ->setLogger($container['logger']);
        };

        return $container;
    }

}