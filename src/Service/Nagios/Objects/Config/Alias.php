<?php

namespace App\Service\Nagios\Objects\Config;

/**
 * Class Alias
 */
class Alias implements ObjectConfigInterface
{
    /** @var string */
    private $alias;

    /**
     * Alias constructor.
     *
     * @param string $alias
     */
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get the configured value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->alias;
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
        return 'alias';
    }
}
