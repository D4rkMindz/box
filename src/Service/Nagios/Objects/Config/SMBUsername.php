<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class SMBUsername
 */
class SMBUsername implements ObjectConfigInterface
{
    /** @var string */
    private $username;

    /**
     * SMBUsername constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->username;
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
        return 'smb_user_name';
    }
}
