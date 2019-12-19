<?php

namespace App\Service\Nagios\Exception;

use InvalidArgumentException;

/**
 * Class TemplateAlreadyExistsException
 */
class HostAlreadyExistsException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct(__('The host already exists'));
    }
}
