<?php

namespace App\Repository;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Monolog\Logger;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        // MUST IMPLEMENT
    }

    public function persistNewRefreshToken(): void
    {
        // MUST IMPLEMENT
    }

    public function revokeRefreshToken(): void
    {
        // MUST IMPLEMENT
    }

    public function isRefreshTokenRevoked(): boolean
    {
        // MUST IMPLEMENT
        return false;
    }

        /**
     * Setter injection
     * @param Logger $logger
     * @return Router
     */
    public function setLogger(Logger $logger): AuthCodeRepository
    {
        $this->logger = $logger;
        return $this;
    }
}
