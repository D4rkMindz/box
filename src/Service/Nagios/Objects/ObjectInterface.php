<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\ObjectConfigInterface;

/**
 * Class ObjectInterface
 */
interface ObjectInterface
{
    /**
     * Get all ObjectConfigurations that are required for the object to be created
     *
     * @return array That is build like __CLASS__ => ['required' => boolean]
     */
    public static function getObjectConfig(): array;

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
