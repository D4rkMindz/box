<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class ConfigInterface
 */
interface ObjectConfigInterface
{
    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Get the template variable name.
     *
     * @see https://git.rievo.net/snippets/28#variables
     *
     * @return string
     */
    public function getTemplateVariableName(): string;
}
