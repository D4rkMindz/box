<?php

namespace App\Controller\API;

use App\Service\Encoder\JSONEncoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ObjectController
 */
class ObjectController
{
    /** @var JSONEncoder */
    private $json;
    /** @var LoggerInterface */
    private $logger;

    /**
     * ObjectController constructor.
     *
     * @param JSONEncoder     $json
     * @param LoggerInterface $logger
     */
    public function __construct(JSONEncoder $json, LoggerInterface $logger)
    {
        $this->json = $json;
        $this->logger = $logger;
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     */
    public function createObjectAction(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->json->encode($response, ['success' => true]);
    }
}
