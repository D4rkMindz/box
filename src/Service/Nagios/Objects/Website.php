<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\CheckInterval;
use App\Service\Nagios\Objects\Config\Domain;
use App\Service\Nagios\Objects\Config\HostName;
use App\Service\Nagios\Objects\Config\ObjectConfigInterface;

/**
 * Class Website
 */
class Website implements ObjectInterface
{
    /** @var HostName */
    private $hostName;
    /** @var Domain */
    private $domain;
    /** @var CheckInterval */
    private $checkInterval;

    /**
     * Website constructor.
     *
     * @param HostName      $hostName
     * @param Domain        $domain
     * @param CheckInterval $checkInterval
     */
    public function __construct(HostName $hostName, Domain $domain, CheckInterval $checkInterval)
    {
        $this->hostName = $hostName;
        $this->domain = $domain;
        $this->checkInterval = $checkInterval;
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
