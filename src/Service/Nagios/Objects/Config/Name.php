<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class Name
 */
class Name implements ObjectConfigInterface
{
    /** @var string */
    private $name;

    /**
     * Name constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
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
        return 'name';
    }
}
