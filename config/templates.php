<?php

use App\Service\Nagios\Objects\Uplink;

$templates = [];
$templates[Uplink::class] = [
    'name' => __('Uplink'),
    'description' => __('This is a check, if the network of the box is connected to the internet.'),
    'file' => 'Uplink.template',
];

return $templates;
