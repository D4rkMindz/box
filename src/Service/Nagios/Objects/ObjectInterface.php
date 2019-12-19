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

    /**
     * Get the name of an object
     *
     * This is the name that is used in the frontend for the user to uniquely identify the object (e.g. "Web server 1")
     *
     * @return string
     */
    public function getName(): string;
}
