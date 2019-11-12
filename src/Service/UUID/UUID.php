<?php

namespace App\Service\UUID;

use Ramsey\Uuid\Uuid as UuidGenerator;

/**
 * Class UUID
 */
class UUID
{
    /**
     * Generate a UUID
     *
     * @return string
     */
    public static function generate()
    {
        return UuidGenerator::uuid4()->toString();
    }
}
