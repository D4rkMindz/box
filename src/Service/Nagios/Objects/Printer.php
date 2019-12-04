<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\Alias;
use App\Service\Nagios\Objects\Config\CheckInterval;
use App\Service\Nagios\Objects\Config\HostName;
use App\Service\Nagios\Objects\Config\ObjectConfigInterface;
use App\Service\Nagios\Objects\Config\SNMPCommunity;

/**
 * Class Printer
 */
class Printer implements ObjectInterface
{
    /** @var HostName */
    private $hostname;
    /** @var Alias */
    private $alias;
    /** @var CheckInterval */
    private $checkInterval;
    /** @var SNMPCommunity */
    private $snmpCommunity;

    /**
     * Printer constructor.
     *
     * @param HostName $hostname
     * @param Alias $alias
     * @param CheckInterval $checkInterval
     * @param SNMPCommunity $snmpCommunity
     */
    public function __construct(
        HostName $hostname,
        Alias $alias,
        CheckInterval $checkInterval,
        SNMPCommunity $snmpCommunity
    ) {
        $this->hostname = $hostname;
        $this->alias = $alias;
        $this->checkInterval = $checkInterval;
        $this->snmpCommunity = $snmpCommunity;
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
            Alias::class => ['required' => true],
            CheckInterval::class => ['required' => true],
            SNMPCommunity::class => ['required' => true],
        ];
    }

    /**
     * Get all configurations of an object.
     *
     * @return ObjectConfigInterface[]
     */
    public function getConfig(): array
    {
        return [
            $this->hostname,
            $this->alias,
            $this->checkInterval,
            $this->snmpCommunity,
        ];
    }

    /**
     * Get the name of the template.
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'printer.template';
    }
}
