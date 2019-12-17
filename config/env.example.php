<?php

use App\Service\Nagios\NagiosInterface;
use GuzzleHttp\ClientInterface;

$env = [];

$env['displayErrorDetails'] = true;

$env['mailgun']['from'] = 'noreply@venovum.com';
$env['mailgun']['apikey'] = 'your-key';
$env['mailgun']['domain'] = 'venovum.com';

$env['debugmail']['host'] = 'debugmail.io';
$env['debugmail']['port'] = 25;
$env['debugmail']['username'] = 'noreply@venovum.com';
$env['debugmail']['password'] = 'your-password';

$env['twig']['assetCache']['minify'] = false;
$env['twig']['assetCache']['cache_enabled'] = false;
$env['twig']['autoReload'] = true;

$env[ClientInterface::class]['base_uri'] = 'https://admin.zently.ch';
$env[ClientInterface::class]['api_uri'] = '/api';

$env[NagiosInterface::class]['nagios_root'] = '/usr/local/nagios';
$env[NagiosInterface::class]['config_root'] = 'etc/';
$env[NagiosInterface::class]['template_root'] = 'templates/';
$env[NagiosInterface::class]['object_root'] = 'etc/objects/';
$env[NagiosInterface::class]['main_config'] = 'etc/nagios.cfg';

return $env;
