<?php

namespace App\Controller;

use App\Service\Encoder\HTMLEncoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AdminController
 */
class AdminController
{
    /** @var HTMLEncoder */
    private $encoder;

    /**
     * AdminController constructor.
     *
     * @param HTMLEncoder $encoder
     */
    public function __construct(HTMLEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function indexAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->encoder->encode($request, $response, 'Admin/index.html.twig');
    }
}
