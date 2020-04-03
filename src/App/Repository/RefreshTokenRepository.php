<?php

namespace App\Repository;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use Monolog\Logger;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function getNewRefreshToken(): RefreshTokenEntityInterface
    {
        // MUST IMPLEMENT
    }

    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        // MUST IMPLEMENT
    }

    public function revokeRefreshToken($tokenId)
    {
        // MUST IMPLEMENT
    }

    public function isRefreshTokenRevoked($tokenId): boolean
    {
        // MUST IMPLEMENT
        return false;
    }

        /**
     * Setter injection
     * @param Logger $logger
     * @return Router
     */
    public function setLogger(Logger $logger): RefreshTokenRepository
    {
        $this->logger = $logger;
        return $this;
    }
}
