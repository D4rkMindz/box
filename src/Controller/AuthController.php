<?php

namespace App\Controller;

use App\Service\Encoder\HTMLEncoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AuthController
 */
class AuthController
{
    /** @var HTMLEncoder */
    private $encoder;
    /** @var LoggerInterface */
    private $logger;

    /**
     * IndexController constructor.
     *
     * @param HTMLEncoder     $encoder
     * @param LoggerInterface $logger
     */
    public function __construct(
        HTMLEncoder $encoder,
        LoggerInterface $logger
    ) {
        $this->encoder = $encoder;
        $this->logger = $logger;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->encoder->encode($response, ['template' => 'Auth/index.html.twig']);
    }
}
