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

            $privateKey = 'file://' . __DIR__ . DIRECTORY_SEPERATOR . '..' . DIRECTORY_SEPERATOR . 'jwk/private.key';

            // generate using base64_encode(random_bytes(32))
            $encryptionKey = 'mwVGS+jB/41fBG6XLXug9VOXFV/sHc9jEaYxoQJUkK8=';

            // Setup the authorization server
            $server = new \League\OAuth2\Server\AuthorizationServer(
                $container['clientRepository'],
                $container['accessTokenRepository'],
                $container['scopeRepository'],
                $container['privateKey'],
                $container['encryptionKey']
            );

            $grant = new \League\OAuth2\Server\Grant\AuthCodeGrant(
                $container['authCodeRepository'],
                $container['refreshTokenRepository'],
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

        };

        return $container;
    }

}