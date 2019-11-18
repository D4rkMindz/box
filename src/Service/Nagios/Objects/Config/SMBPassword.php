<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class SMBPassword
 */
class SMBPassword
{
    /** @var string */
    private $password;

    /**
     * SMBPassword constructor.
     *
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->password;
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
        return 'smb_password';
    }
}
