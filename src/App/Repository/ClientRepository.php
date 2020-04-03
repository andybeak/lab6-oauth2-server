<?php

namespace App\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Monolog\Logger;


/**
 * Class ClientRepository
 * @package App\Repository
 */
class ClientRepository implements ClientRepositoryInterface
{

    /**
     * We're hard coding this because we're only supporting our own client
     * In a more complicated environment with multiple clients we'd use a
     * database.
     * @var string
     */
    private $clientSecret = '57087841224e';

    /**
     * @param string $clientIdentifier
     * @return ClientEntityInterface
     */
    public function getClientEntity($clientIdentifier) : ClientEntityInterface
    {

        return new class($clientIdentifier) implements ClientEntityInterface {

            private $clientIdentifier;

            public function __construct($clientIdentifier)
            {
                $this->clientIdentifier = $clientIdentifier;
            }

            public function getIdentifier()
            {
                return $this->clientIdentifier;
            }

            public function getName()
            {
                return "Demo client";
            }

            public function getRedirectUri()
            {
                return "http://localhost/oauth2/callback";
            }

            public function isConfidential()
            {
                return false;
            }
        };
    }

    /**
     * @param string $clientIdentifier
     * @param string|null $clientSecret
     * @param string|null $grantType
     * @return bool
     */
    public function validateClient($clientIdentifier, $clientSecret, $grantType) : bool
    {
        return true;
    }
    
    /**
     * Setter injection
     * @param Logger $logger
     * @return Router
     */
    public function setLogger(Logger $logger): Controller
    {
        $this->logger = $logger;
        return $this;
    }
}
