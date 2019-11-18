<?php

namespace App\Service\Nagios\Objects\Config;

use InvalidArgumentException;

/**
 * Class SMBWarningPercent
 */
class SMBWarningPercent implements ObjectConfigInterface
{
    /** @var int */
    private $percent;

    public function __construct(int $percent)
    {
        if ($percent < 0 || $percent > 100) {
            throw new InvalidArgumentException(__('SMB warning percent must be between 0 and 100'));
        }
        $this->percent = $percent;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string {
        return (string)$this->percent;
    }

    /**
     * Get the template variable name.
     *
     * @see https://git.rievo.net/snippets/28#variables
     *
     * @return string
     */
    public function getTemplateVariableName(): string {
        return 'smb_warning_percent';
    }
}
