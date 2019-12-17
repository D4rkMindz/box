<?php

namespace App\Type;

/**
 * Class SessionKey
 */
class SessionKey
{
    public const AUTHENTICATED = 'authenticated';
    public const TOKENS = 'tokens';
    public const REFRESH_TOKEN = 'refresh';
    public const JWT = 'jwt';
    public const JWT_DECODED = 'jwt_decoded';
}
