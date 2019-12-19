<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class HostName
 */
class HostName implements ObjectConfigInterface
{
    /** @var string */
    private $hostname;

    /**
     * HostName constructor.
     *
     * @param string $hostname
     */
    public function __construct(string $hostname)
    {
        $this->hostname = $hostname;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->hostname;
    }

    /**
     * Get the template variable name.
     *
     * @see https://git.rievo.net/snippets/28#variables
     *
     * @return string
     */
    public static function getTemplateVariableName(): string
    {
        return 'host_name';
    }
}
