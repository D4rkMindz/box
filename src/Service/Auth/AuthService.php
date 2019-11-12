<?php

namespace App\Service\Auth;

use App\Exception\AuthenticationException;
use App\Exception\RecordNotFoundException;
use App\Repository\UserDataRepository;
use App\Repository\UserRepository;
use App\Service\SettingsInterface;
use App\Service\Type\UserDataKey;
use Codeception\Util\HttpCode;
use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Firebase\JWT\JWT;

/**
 * Class AuthService
 */
class AuthService
{
    /** @var array */
    private $config;

    /**
     * AuthService constructor.
     *
     * @param SettingsInterface  $settings
     */
    public function __construct(
        SettingsInterface $settings
    ) {
        $this->config = $settings->get(JWT::class);
    }

    /**
     * Check if a user can login.
     *
     * @param int    $userId
     * @param string $password
     *
     * @return bool
     */
    public function canLogin(int $userId, string $password)
    {
        return true;
    }
}
