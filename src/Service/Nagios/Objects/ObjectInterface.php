<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\ObjectConfigInterface;

/**
 * Class ObjectInterface
 */
interface ObjectInterface
{
    /**
     * Get all configurations of an object.
     *
     * @return ObjectConfigInterface[]
     */
    public function getConfig(): array;

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getTemplateName(): string;
}
