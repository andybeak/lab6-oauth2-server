<?php

namespace App\Repository;

use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use Monolog\Logger;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    public function getNewAuthCode(): AuthCodeEntityInterface
    {

    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity): void
    {

    }

    public function revokeAuthCode($codeId): void
    {

    }

    public function isAuthCodeRevoked($codeId): boolean
    {

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
