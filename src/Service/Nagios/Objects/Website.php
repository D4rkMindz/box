<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\CheckInterval;
use App\Service\Nagios\Objects\Config\Domain;
use App\Service\Nagios\Objects\Config\HostName;
use App\Service\Nagios\Objects\Config\Name;
use App\Service\Nagios\Objects\Config\ObjectConfigInterface;

/**
 * Class Website
 */
class Website implements ObjectInterface
{
    /** @var Name */
    private $name;
    /** @var HostName */
    private $hostName;
    /** @var Domain */
    private $domain;
    /** @var CheckInterval */
    private $checkInterval;

    /**
     * Website constructor.
     *
     * @param HostName      $hostname
     * @param Domain        $domain
     * @param CheckInterval $checkInterval
     */
    public function __construct(HostName $hostname, Domain $domain, CheckInterval $checkInterval)
    {
        $this->name = new Name($hostname->getValue());
        $this->hostName = $hostname;
        $this->domain = $domain;
        $this->checkInterval = $checkInterval;
    }

    /**
     * Get all ObjectConfigurations that are required for the object to be created
     *
     * @return array That is build like __CLASS__ => ['required' => boolean]
     */
    public static function getObjectConfig(): array
    {
        return [
            HostName::class => ['required' => true],
            Domain::class => ['required' => true],
            CheckInterval::class => ['required' => true],
        ];
    }

    /**
     * Get the name of the website
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name->getValue();
    }

    /**
     * Get all configurations of an object.
     *
     * @return ObjectConfigInterface[]
     */
    public function getConfig(): array
    {
        return [
            $this->hostName,
            $this->domain,
            $this->checkInterval,
        ];
    }

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'website.template';
    }
}
