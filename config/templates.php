<?php

use App\Service\Nagios\Objects\Config\Address;
use App\Service\Nagios\Objects\Config\Alias;
use App\Service\Nagios\Objects\Config\CheckInterval;
use App\Service\Nagios\Objects\Config\Domain;
use App\Service\Nagios\Objects\Config\HostName;
use App\Service\Nagios\Objects\Config\SNMPCommunity;
use App\Service\Nagios\Objects\Printer;
use App\Service\Nagios\Objects\Uplink;
use App\Service\Nagios\Objects\Website;

/**
 * Only reveal the class name to the public because otherwise the client might instantiate
 * some classes from the application providing some fake parameters
 * => Security vulnerability
 */

$templates = [];
$templates[] = [
    'name' => __('Uplink'),
    'class' => class_name(Uplink::class),
    'description' => __('This is a check, if the network of the box is connected to the internet.'),
    'fields' => [
        class_name(HostName::class) => ['type' => 'HostName', 'value' => '', 'valid' => null],
        class_name(Alias::class) => ['type' => 'Alias', 'value' => '', 'valid' => null],
        class_name(Address::class) => ['type' => 'Address', 'value' => '', 'valid' => null],
        class_name(CheckInterval::class) => ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
    ],
];
$templates[] = [
    'name' => __('Regular Printer'),
    'class' => class_name(Printer::class),
    'description' => __('This checks if the printer works as expected'),
    'fields' => [
        class_name(HostName::class) => ['type' => 'HostName', 'value' => '', 'valid' => null],
        class_name(Alias::class) => ['type' => 'Alias', 'value' => '', 'valid' => null],
        class_name(CheckInterval::class) => ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
        class_name(SNMPCommunity::class) => ['type' => 'SnmpCommunity', 'value' => 'public', 'valid' => null],
    ],
];
$templates[] = [
    'name' => __('Website'),
    'class' => class_name(Website::class),
    'description' => __('This checks if a website is up and reacheable'),
    'fields' => [
        class_name(HostName::class) => ['type' => 'HostName', 'value' => '', 'valid' => null],
        class_name(Domain::class) => ['type' => 'Domain', 'value' => '', 'valid' => null],
        class_name(CheckInterval::class) => ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
    ],
];

return $templates;
