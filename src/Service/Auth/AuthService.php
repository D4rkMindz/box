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
     *
     * @return array
     */
    public function login(string $username, string $password): array
    {
        return $this->apiAuth->login($username, $password);
    }
}
