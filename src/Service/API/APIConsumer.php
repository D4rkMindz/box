<?php

namespace App\Service\API;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class APIConsumer
 */
class APIConsumer
{
    /** @var ClientInterface */
    private $client;

    /**
     * APIConsumer constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Send GET
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface
     */
    public function get(string $url, array $options = [])
    {
        return $this->client->request('GET', $url, $options);
    }

    /**
     * Send POST
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return ResponseInterface
     */
    public function post(string $url, array $data = [], array $options = [])
    {
        $options['json'] = $data;

        return $this->client->request('POST', $url, $options);
    }

    /**
     * Send PUT
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return ResponseInterface
     */
    public function put(string $url, array $data = [], array $options = [])
    {
        $options['body'] = json_encode($data);

        return $this->client->request('PUT', $url, $options);
    }

    /**
     * Send DELETE
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface
     */
    public function delete(string $url, array $options = [])
    {
        return $this->client->request('DELETE', $url, $options);
    }
}
