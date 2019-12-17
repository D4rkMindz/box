<?php

namespace App\Service\API;

use App\Type\ErrorCode;
use App\Util\ArrayReader;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseParser
 */
class ResponseParser
{
    /** @var ResponseInterface */
    private $response;

    /**
     * ResponseParser constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get the content
     *
     * @return ArrayReader
     */
    public function getContent(): ArrayReader
    {
        $contentType = $this->response->getHeader('Content-Type');
        if (strpos(strtolower($contentType[0]),'application/json') !== false) {
            $json = $this->response->getBody()->getContents();

            return new ArrayReader(json_decode($json, true));
        }

        throw new InvalidArgumentException(__('Admin server gave invalid response'), ErrorCode::NOT_JSON);
    }

    /**
     * Get the status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }
}
