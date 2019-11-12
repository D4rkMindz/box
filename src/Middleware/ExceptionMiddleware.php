<?php

namespace App\Middleware;

use App\Service\Encoder\HTMLEncoder;
use App\Service\Status\StatusCode;
use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ExceptionMiddleware.
 */
class ExceptionMiddleware implements MiddlewareInterface
{
    /** @var HTMLEncoder */
    private $encoder;

    /** @var ResponseFactoryInterface */
    private $responseFactory;

    /**
     * ExceptionMiddleware constructor.
     *
     * @param HTMLEncoder              $encoder
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(HTMLEncoder $encoder, ResponseFactoryInterface $responseFactory)
    {
        $this->encoder = $encoder;
        $this->responseFactory = $responseFactory;
    }

    /**
     * The called method.
     *
     * This method will be invoked if a middleware is executed
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Exception $exception) {
            $response = $this->responseFactory->createResponse(200);

            return $this->encoder->encode($request, $response, 'Error/index.html.twig');
        }
    }

}
