<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class HostName
 */
class Domain implements ObjectConfigInterface
{
    /** @var string */
    private $domain;

    /**
     * HostName constructor.
     *
     * @param string $domain
     */
    public function __construct(string $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->domain;
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
        return 'domain';
    }
}
