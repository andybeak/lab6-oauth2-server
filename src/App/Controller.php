<?php

namespace App;

use Psr\Log\LoggerInterface;

class Controller
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function home(Request $request, array $vars): void
    {
        echo "Hello World";

    }

    /**
     * Setter injection
     * @param LoggerInterface $logger
     * @return Router
     */
    public function setLogger(LoggerInterface $logger): Controller
    {
        $this->logger = $logger;
        return $this;
    }
}