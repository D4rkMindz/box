<?php

namespace App\Service\Auth;

use App\Service\API\APIAuthService;

/**
 * Class AuthService
 */
class AuthService
{
    /** @var APIAuthService */
    private $apiAuth;

    /**
     * AuthService constructor.
     *
     * @param APIAuthService $apiAuth
     */
    public function __construct(
        APIAuthService $apiAuth
    ) {
        $this->apiAuth = $apiAuth;
    }

    /**
     * Check if a user can login.
     *
     * @param string $username
     * @param string $password
     * @param string $key The update key of the box (is defined in the table box.update_key on the admin server, and also saved on the box)
     *
     * @return array
     */
    public function login(string $username, string $password, string $key): array
    {
        return $this->apiAuth->login($username, $password, $key);
    }
}
