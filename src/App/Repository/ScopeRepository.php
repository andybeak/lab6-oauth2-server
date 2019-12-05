<?php

namespace App\Repository;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

class ScopeRepository implements ScopeRepositoryInterface
{
    public function getScopeEntityByIdentifier($identifier)
    {
        return new class($identifier) extends JsonSerializable implements ScopeEntityInterface
        {
            private $identifier;

            public function __construct($identifier)
            {
                $this->identifier = $identifier;
            }

            public function getIdentifier()
            {
                return $this->identifier;
            }

            public function jsonSerialize()
            {
                return json_encode($this->identifier);
            }
        };
    }

    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        return [];
    }
}