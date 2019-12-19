<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class HostName
 */
class Address implements ObjectConfigInterface
{
    /** @var string */
    private $address;

    /**
     * HostName constructor.
     *
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = $address;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->address;
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
        return 'address';
    }
}
