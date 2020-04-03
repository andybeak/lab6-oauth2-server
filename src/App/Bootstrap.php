<?php

namespace App;

use Pimple\Container;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Repository\{
    AccessToken,
    AccessTokenRepository,
    AuthCodeEntity,
    AuthCodeRepository,
    RefreshTokenRepository,
    ClientRepository,
    ScopeRepository};

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
                $r->addRoute('GET', '/authorize', 'authorize');
                $r->addRoute('POST', '/access_token', 'access_token');
            });
        };

        $container['controller'] = function($container) {
            return (new Controller())
                ->setLogger($container['logger'])
                ->setServer($container['AuthorizationServer']);
        };

        $container['ClientRepository'] = function($container) {
            return (new ClientRepository())
                ->setLogger($container['logger']);
        };

        $container['ScopeRepository'] = function($container) {
            return (new ScopeRepository())
                ->setLogger($container['logger']);
        };

        $container['AccessTokenRepository'] = function($container) {
            return (new AccessTokenRepository())
                ->setLogger($container['logger']);
        };

        $container['AuthCodeRepository'] = function($container) {
            return (new AuthCodeRepository())
                ->setLogger($container['logger']);
        };

        $container['RefreshTokenRepository'] = function($container) {
            return (new RefreshTokenRepository())
                ->setLogger($container['logger']);
        };

        $container['AuthorizationServer'] = function($container) {
            // see https://oauth2.thephpleague.com/authorization-server/auth-code-grant/

            $privateKey = 'file://' . __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'jwk/private.key';

            // generate using base64_encode(random_bytes(32))
            $encryptionKey = 'U26rujX/iWK3ZPoDx925Th867fnTYAXaVVGey9wh7Yw=';

            // Setup the authorization server
            $server = new \League\OAuth2\Server\AuthorizationServer(
                $container['ClientRepository'],
                $container['AccessTokenRepository'],
                $container['ScopeRepository'],
                $privateKey,
                $encryptionKey
            );

            $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
                $container['AuthCodeRepository'],
                $container['RefreshTokenRepository'],
                // authorization codes will expire after 10 minutes
                new \DateInterval('PT10M')
            );

            // refresh tokens will expire after 1 month
            $grant->setRefreshTokenTTL(new \DateInterval('P1M'));

            // Enable the authentication code grant on the server
            $server->enableGrantType(
                $grant,
                new \DateInterval('PT1H') // access tokens will expire after 1 hour
            );

            return $server;

        };

        return $container;
    }

}
