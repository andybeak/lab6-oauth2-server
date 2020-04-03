<?php

namespace App;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Request;
use \League\OAuth2\Server\Exception\OAuthServerException;

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

    public function authorize(Request $request, array $vars)
    {
        try {

            // Validate the HTTP request and return an AuthorizationRequest object.
            $authRequest = $this->server->validateAuthorizationRequest($request);

            // The auth request object can be serialized and saved into a user's session.
            // You will probably want to redirect the user at this point to a login endpoint.

            // Once the user has logged in set the user on the AuthorizationRequest
            $authRequest->setUser(new UserEntity()); // an instance of UserEntityInterface

            // At this point you should redirect the user to an authorization page.
            // This form will ask the user to approve the client and the scopes requested.

            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);

            // Return the HTTP redirect response
            return $this->server->completeAuthorizationRequest($authRequest, $response);

        } catch (OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);

        } catch (\Exception $exception) {

            // Unknown exception
            $body = new Stream(fopen('php://temp', 'r+'));
            $body->write($exception->getMessage());
            return $response->withStatus(500)->withBody($body);

        }
    }

    public function access_token(Request $request, array $vars)
    {
        try {

            // Try to respond to the request
            return $this->server->respondToAccessTokenRequest($request, $response);

        } catch (\League\OAuth2\Server\Exception\OAuthServerException $exception) {

            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);

        } catch (\Exception $exception) {

            // Unknown exception
            $body = new Stream(fopen('php://temp', 'r+'));
            $body->write($exception->getMessage());
            return $response->withStatus(500)->withBody($body);
        }
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

    public function setServer($server): Controller
    {
        $this->server = $server;
        return $this;
    }

}
