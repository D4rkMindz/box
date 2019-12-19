<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class SMBShareName
 */
class SMBShareName implements ObjectConfigInterface
{
    /** @var string */
    private $shareName;

    /**
     * SMBShareName constructor.
     *
     * @param string $shareName
     */
    public function __construct(string $shareName)
    {
        $this->shareName = $shareName;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->shareName;
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
        return 'smb_share_name';
    }
}
