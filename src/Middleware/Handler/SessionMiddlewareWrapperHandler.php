<?php

namespace App\Middleware\Handler;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware as PSRSessionMiddleware;
use PSR7Sessions\Storageless\Session\SessionInterface;

/**
 * Class SessionMiddlewareHandler
 */
class SessionMiddlewareWrapperHandler implements RequestHandlerInterface
{
    /** @var RequestHandlerInterface */
    private $handler;
    /** @var ContainerInterface */
    private $container;

    /**
     * SessionMiddlewareWrapperHandler constructor.
     *
     * @param RequestHandlerInterface $originalHandler
     * @param ContainerInterface      $container
     */
    public function __construct(RequestHandlerInterface $originalHandler, ContainerInterface $container)
    {
        $this->handler = $originalHandler;
        $this->container = $container;
    }

    /**
     * Handle request
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $session = $request->getAttribute(PSRSessionMiddleware::SESSION_ATTRIBUTE);
        $this->container->set(SessionInterface::class, $session);

        return $this->handler->handle($request);
    }
}
