<?php

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

return $env;
