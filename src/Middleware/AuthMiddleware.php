<?php

namespace App\Middleware;

use App\Service\Auth\AuthService;
use App\Service\Encoder\RedirectEncoder;
use App\Service\SettingsInterface;
use App\Type\HttpCode;
use App\Type\SessionKey;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use PSR7Sessions\Storageless\Session\LazySession;
use Slim\Routing\RouteContext;

/**
 * Class AuthMiddleware
 */
class AuthMiddleware implements MiddlewareInterface
{
    /** @var AuthService */
    private $auth;

    /** @var ResponseFactoryInterface */
    private $responseFactory;

    /** @var RedirectEncoder */
    private $redirect;

    /**
     * AuthMiddleware constructor.
     *
     * @param ResponseFactoryInterface $responseFactory
     * @param RedirectEncoder          $redirect
     * @param SettingsInterface        $settings
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        RedirectEncoder $redirect,
        SettingsInterface $settings
    ) {
        $this->responseFactory = $responseFactory;
        $this->redirect = $redirect;
        $this->unsecureRoutes = $settings->get('auth')['relaxed'];
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var LazySession $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        $routeName = RouteContext::fromRequest($request)->getRoute()->getName();

        if ((bool)$session->get(SessionKey::AUTHENTICATED) || isset($this->unsecureRoutes[$routeName])) {
            return $handler->handle($request);
        }

        $response = $this->responseFactory->createResponse(HttpCode::TEMPORARY_REDIRECT);

        return $this->redirect->encode($response, '/login');
    }
}
