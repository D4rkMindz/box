<?php

namespace App\Service\Encoder;

use Psr\Http\Message\ResponseInterface;

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
     * @param int               $status
     *
     * @return ResponseInterface
     */
    public function encode(ResponseInterface $response, array $data, int $status = 200): ResponseInterface
    {
        $json = json_encode($data);
        $body = $response->getBody();
        $body->rewind();
        $body->write($json);

        return $response->withAddedHeader('Content-Type', 'application/json')->withStatus($status);
    }
}
