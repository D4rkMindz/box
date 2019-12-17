<?php

namespace App\Service\API;

use App\Service\SettingsInterface;
use GuzzleHttp\ClientInterface;

/**
 * Class APIConsumer
 */
class APIConsumer
{
    /** @var ClientInterface */
    private $client;
    /** @var string */
    private $apiURI;

    /**
     * APIConsumer constructor.
     *
     * @param ClientInterface   $client
     * @param SettingsInterface $settings
     */
    public function __construct(ClientInterface $client, SettingsInterface $settings)
    {
        $this->client = $client;
        $this->apiURI = $settings->get(ClientInterface::class)['api_uri'];
    }

    /**
     * Send GET
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseParser
     */
    public function get(string $url, array $options = []): ResponseParser
    {
        $response = $this->client->request('GET', $this->apiURI . $url, $options);

        return new ResponseParser($response);
    }

    /**
     * Send POST
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return ResponseParser
     */
    public function post(string $url, array $data = [], array $options = []): ResponseParser
    {
        $options['json'] = $data;

        $response = $this->client->request('POST', $this->apiURI . $url, $options);

        return new ResponseParser($response);
    }

    /**
     * Send PUT
     *
     * @param string $url
     * @param array  $data
     * @param array  $options
     *
     * @return ResponseParser
     */
    public function put(string $url, array $data = [], array $options = []): ResponseParser
    {
        $options['body'] = json_encode($data);

        $response = $this->client->request('PUT', $this->apiURI . $url, $options);

        return new ResponseParser($response);
    }

    /**
     * Send DELETE
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseParser
     */
    public function delete(string $url, array $options = []): ResponseParser
    {
        $response = $this->client->request('DELETE', $this->apiURI . $url, $options);

        return new ResponseParser($response);
    }
}
