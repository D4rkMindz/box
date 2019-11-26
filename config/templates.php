<?php

use App\Service\Nagios\Objects\Printer;
use App\Service\Nagios\Objects\Uplink;

$templates = [];
$templates[Uplink::class] = [
    'name' => __('Uplink'),
    'description' => __('This is a check, if the network of the box is connected to the internet.'),
    'fields' => [
        ['type' => 'HostName', 'value' => ''],
        ['type' => 'Alias', 'value' => ''],
        ['type' => 'Address', 'value' => ''],
        ['type' => 'CheckInterval', 'value' => 1],
    ],
];
$templates[Printer::class] = [
    'name' => __('Regular Printer'),
    'description' => __('This checks if the printer works as expected'),
    'fields' => [
        ['type' => 'HostName', 'value' => ''],
        ['type' => 'Alias', 'value' => ''],
        ['type' => 'CheckInterval', 'value' => ''],
        ['type' => 'SnmpCommunity', 'value' => 'public'],
    ],
];

return $templates;
