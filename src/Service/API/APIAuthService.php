<?php

namespace App\Service\API;

use App\Exception\AuthenticationException;
use App\Type\HttpCode;
use App\Util\ArrayReader;

/**
 * Class APIAuthService
 */
class APIAuthService
{
    /** @var APIConsumer */
    private $api;

    /**
     * APIAuthService constructor.
     *
     * @param APIConsumer $api
     */
    public function __construct(APIConsumer $api)
    {
        $this->api = $api;
    }

    /**
     * Login
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function login(string $username, string $password): array
    {
        $response = $this->api->post('/api/tokens', [
            'username' => $username,
            'password' => $password,
        ]);

        if ($response->getStatusCode() !== HttpCode::OK) {
            throw new AuthenticationException(HttpCode::UNAUTHORIZED, __('Username or password invalid'));
        }

        $json = $response->getBody()->getContents();
        $data = new ArrayReader(json_decode($json, true));
        $token = $data->findString('access_token');
        $refreshToken = $data->findString('refresh_token');

        return [
            'token' => $token,
            'refresh' => $refreshToken
        ];
    }
}
