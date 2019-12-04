<?php

namespace App\Service\Nagios\Objects;

use App\Service\Nagios\Objects\Config\Address;
use App\Service\Nagios\Objects\Config\Alias;
use App\Service\Nagios\Objects\Config\CheckInterval;
use App\Service\Nagios\Objects\Config\HostName;
use App\Service\Nagios\Objects\Config\ObjectConfigInterface;

/**
 * Class Uplink
 */
class Uplink implements ObjectInterface
{
    /** @var HostName */
    private $hostName;
    /** @var Alias */
    private $alias;
    /** @var Address */
    private $address;
    /** @var CheckInterval */
    private $checkInterval;

    /**
     * Uplink constructor.
     *
     * @param HostName      $name
     * @param Alias         $alias
     * @param Address       $address
     * @param CheckInterval $checkInterval
     */
    public function __construct(HostName $name, Alias $alias, Address $address, CheckInterval $checkInterval)
    {
        $this->hostName = $name;
        $this->alias = $alias;
        $this->address = $address;
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
            Alias::class => ['required' => true],
            Address::class => ['required' => true],
            CheckInterval::class => ['required' => true],
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
            $this->hostName,
            $this->alias,
            $this->address,
            $this->checkInterval,
        ];
    }

    /**
     * Get the template name.
     *
     * @return string
     */
    public function getTemplateName(): string
    {
        return 'uplink.template';
    }
}
