<?php

namespace App\Service\Encoder;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Stream;

/**
 * Class JSONEncoder
 */
class JSONEncoder implements EncoderInterface
{
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
        $json = json_encode($data);
        $body = $response->getBody();
        $body->rewind();
        $body->write($json);
        return $response->withAddedHeader('Content-Type', 'application/json');
    }
}
