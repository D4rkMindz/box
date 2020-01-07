<?php

namespace App\Service\API;

use App\Exception\AuthenticationException;
use App\Type\HttpCode;

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
     * @param string $key The update key of the box (is defined in the table box.update_key on the admin server, and also saved on the box)
     *
     * @return array
     */
    public function login(string $username, string $password, string $key): array
    {
        $response = $this->api->post('/tokens', [
            'username' => $username,
            'password' => $password,
            'key' => trim($key)
        ]);

        if ($response->getStatusCode() !== HttpCode::OK) {
            throw new AuthenticationException(HttpCode::UNAUTHORIZED, __('Username or password invalid'));
        }

        $content = $response->getContent();
        if ($content->exists('error')) {
            throw new AuthenticationException(HttpCode::UNAUTHORIZED, __('Username or password invalid'));
        }

        $token = $content->getString('access_token');
        $refreshToken = $content->getString('refresh_token');

        return [
            'token' => $token,
            'refresh' => $refreshToken,
        ];
    }
}
