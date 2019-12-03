<?php

use App\Service\Nagios\Objects\Printer;
use App\Service\Nagios\Objects\Uplink;
use App\Service\Nagios\Objects\Website;

$templates = [];
$templates[Uplink::class] = [
    'name' => __('Uplink'),
    'description' => __('This is a check, if the network of the box is connected to the internet.'),
    'fields' => [
        ['type' => 'HostName', 'value' => '', 'valid' => null],
        ['type' => 'Alias', 'value' => '', 'valid' => null],
        ['type' => 'Address', 'value' => '', 'valid' => null],
        ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
    ],
];
$templates[Printer::class] = [
    'name' => __('Regular Printer'),
    'description' => __('This checks if the printer works as expected'),
    'fields' => [
        ['type' => 'HostName', 'value' => '', 'valid' => null],
        ['type' => 'Alias', 'value' => '', 'valid' => null],
        ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
        ['type' => 'SnmpCommunity', 'value' => 'public', 'valid' => null],
    ],
];
$templates[Website::class] = [
    'name' => __('Website'),
    'description' => __('This checks if a website is up and reacheable'),
    'fields' => [
        ['type' => 'HostName', 'value' => '', 'valid' => null],
        ['type' => 'Domain', 'value' => '', 'valid' => null],
        ['type' => 'CheckInterval', 'value' => '5', 'valid' => null],
    ],
];

return $templates;
