<?php

namespace App\Service\API;

use App\Service\SettingsInterface;
use App\Type\SessionKey;
use GuzzleHttp\ClientInterface;
use PSR7Sessions\Storageless\Session\SessionInterface;

/**
 * Class APIConsumer
 */
class APIConsumer
{
    /** @var ClientInterface */
    private $client;
    /** @var string */
    private $apiURI;
    /** @var SessionInterface */
    private $session;

    /**
     * APIConsumer constructor.
     *
     * @param ClientInterface   $client
     * @param SettingsInterface $settings
     * @param SessionInterface  $session
     */
    public function __construct(ClientInterface $client, SettingsInterface $settings, SessionInterface $session)
    {
        $this->client = $client;
        $this->apiURI = $settings->get(ClientInterface::class)['api_uri'];
        $this->session = $session;
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
        $options = $this->addHeaders($options);
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
        $options = $this->addHeaders($options);

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
        $options = $this->addHeaders($options);

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
        $options = $this->addHeaders($options);
        $response = $this->client->request('DELETE', $this->apiURI . $url, $options);

        return new ResponseParser($response);
    }

    /**
     * Add required headers to request
     *
     * @param array $options
     *
     * @return array
     */
    private function addHeaders(array $options)
    {
        if (!isset($options['headers'])) {
            $options['headers'] = [];
        }
        if ($this->session->get(SessionKey::AUTHENTICATED)) {
            $options['headers']['Authorization'] = $this->session->get(SessionKey::JWT);
        }

        return $options;
    }
}
