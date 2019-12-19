<?php

namespace App\Middleware;

use App\Middleware\Handler\SessionMiddlewareWrapperHandler;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware as PSRSessionMiddleware;

/**
 * Class SessionMiddleware
 */
class SessionMiddleware implements MiddlewareInterface
{
    /** @var PSRSessionMiddleware */
    private $sessionMiddleware;
    /** @var ContainerInterface */
    private $container;

    /**
     * SessionMiddleware constructor.
     *
     * @param PSRSessionMiddleware $sessionMiddleware
     * @param ContainerInterface   $container
     */
    public function __construct(PSRSessionMiddleware $sessionMiddleware, ContainerInterface $container)
    {
        $this->sessionMiddleware = $sessionMiddleware;
        $this->container = $container;
    }

    /**
     * Session middle ware wrapper to write the session into the container
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $wrapperHandler = new SessionMiddlewareWrapperHandler($handler, $this->container);

        return $this->sessionMiddleware->process($request, $wrapperHandler);
    }
}
