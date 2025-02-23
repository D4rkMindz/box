<?php

namespace App\Service\Encoder;

use App\Type\HttpCode;
use Psr\Http\Message\ResponseInterface;
use Slim\App;

/**
 * Class RedirectEncoder
 */
class RedirectEncoder
{
    /** @var string */
    private $base;

    /**
     * RedirectEncoder constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->base = $app->getBasePath();
    }

    /**
     * Encode a response.
     *
     * @param ResponseInterface $response
     * @param string            $url
     *
     * @return ResponseInterface
     */
    public function encode(ResponseInterface $response, string $url): ResponseInterface
    {
        $route = $this->base = $url;

        return $response->withStatus(HttpCode::SEE_OTHER)->withAddedHeader('Location', $route);
    }
}
