<?php

namespace App\Service\Encoder;

use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

/**
 * Class HTMLEncoder
 */
class HTMLEncoder implements EncoderInterface
{
    /** @var Twig */
    private $twig;

    /**
     * HTMLEncoder constructor.
     *
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Encode a response.
     *
     * @param ResponseInterface $response
     * @param array             $data
     *
     * @return ResponseInterface
     */
    public function encode(ResponseInterface $response, array $data): ResponseInterface
    {
        $template = (string)array_value('template', $data);

        return $this->twig->render($response, $template, $data)->withAddedHeader('Content-Type', 'text/html');
    }
}
