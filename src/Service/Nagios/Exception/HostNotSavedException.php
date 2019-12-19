<?php

namespace App\Service\Nagios\Exception;

use InvalidArgumentException;

/**
 * Class HostNotSavedException
 */
class HostNotSavedException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct(__('The host could not be saved. Please try again'));
    }
}
