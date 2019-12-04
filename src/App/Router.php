<?php

namespace App;

use FastRoute\Dispatcher\GroupCountBased;
use Psr\Log\LoggerInterface;
use JWTDemo\App\Exceptions\RouteException;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    /**
     * @var GroupCountBased
     */
    private $dispatcher;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Handler
     */
    private $handler;

    /**
     * @return array
     * @throws RouteException
     */
    public function getRouteInfo(): array
    {

    }

    /**
     * @param $routeInfo
     * @throws RouteException
     */
    public function dispatchRoute($routeInfo): void
    {

    }

    /**
     * Setter injection
     * @param GroupCountBased $dispatcher
     * @return Router
     */
    public function setDispatcher(GroupCountBased $dispatcher): Router
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * Setter injection
     * @param LoggerInterface $logger
     * @return Router
     */
    public function setLogger(LoggerInterface $logger): Router
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param Handler $handler
     * @return Router
     */
    public function setHandler(Handler $handler): Router
    {
        $this->handler = $handler;
        return $this;
    }
}