<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class SNMPCommunity
 */
class SNMPCommunity implements ObjectConfigInterface
{
    /** @var string public is default, otherwise defined inside printer settings */
    public const PUBLIC = 'public';
    /** @var string */
    private $community;

    /**
     * SNMPCommunity constructor.
     *
     * @param string $community
     */
    public function __construct(?string $community)
    {
        $this->community = $community ?: self::PUBLIC;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->community;
    }

    /**
     * Get the template variable name.
     *
     * @see https://git.rievo.net/snippets/28#variables
     *
     * @return string
     */
    public function getTemplateVariableName(): string
    {
        return 'snmp_community';
    }
}
