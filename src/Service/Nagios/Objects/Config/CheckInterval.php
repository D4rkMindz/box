<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class CheckInterval
 */
class CheckInterval implements ObjectConfigInterface
{
    /** @var int */
    private $checkInterval;

    /**
     * CheckInterval constructor.
     *
     * @param int $checkInterval
     */
    public function __construct(int $checkInterval)
    {
        $this->checkInterval = $checkInterval;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return (string)$this->checkInterval;
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
        return 'check_interval';
    }
}
