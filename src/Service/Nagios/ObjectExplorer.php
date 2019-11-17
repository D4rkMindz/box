<?php

namespace App\Service\Nagios;

use App\Service\SettingsInterface;

/**
 * Class ObjectExplorer
 */
class ObjectExplorer
{
    public function __construct(SettingsInterface $settings)
    {
        $this->config = $settings->get(NagiosInterface::class);
    }
}
