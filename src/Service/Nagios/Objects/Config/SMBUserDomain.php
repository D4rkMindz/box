<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class SMBUserDomain
 */
class SMBUserDomain implements ObjectConfigInterface
{
    /** @var string */
    private $UserDomain;

    /**
     * SMBUserDomain constructor.
     *
     * @param string $UserDomain
     */
    public function __construct(string $UserDomain)
    {
        $this->UserDomain = $UserDomain;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->UserDomain;
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
        return 'smb_user_domain';
    }
}
