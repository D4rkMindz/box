<?php

namespace App\Service\Nagios\Exception;

use InvalidArgumentException;

/**
 * Class TemplateAlreadyExistsException
 */
class TemplateAlreadyExistsException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct(__('The template already exists'));
    }
}
