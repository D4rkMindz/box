<?php

use App\Service\Nagios\NagiosInterface;
use Firebase\JWT\JWT;
use GuzzleHttp\ClientInterface;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use PSR7Sessions\Storageless\Session\SessionInterface;
use Symfony\Component\Translation\Translator;

ini_set("error_reporting", E_ALL & ~E_DEPRECATED);

$config = [];

$applicationName = 'Box';

$config = [
    'name' => $applicationName,
    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => true,
    'addContentLengthHeader' => false,
    'public' => __DIR__.'/../public'
];

$config[Translator::class] = [
    'locale' => 'en_US',
    'path' => __DIR__ . '/../resources/locale',
];

$config[ClientInterface::class] = [
    'base_uri' => 'https://api.example.com',
];

$config['twig'] = [
    'path' => __DIR__ . '/../templates',
    'cache' => [
        'enabled' => true,
        'path' => __DIR__ . '/../tmp/cache/twig',
    ],
    'autoReload' => false,
];

$config['mailgun'] = [
    'from' => '',
    'apikey' => '',
    'domain' => '',
];

$config['debugmail'] = [
    'host' => '',
    'port' => 0,
    'username' => '',
    'password' => '',
];

$config['auth'] = [
    'relaxed' => [
        'root' => true,
        'auth' => true,
        'auth.login' => true,
    ]
];

$filename = date('Y-m-d') . '_application';
$config[LoggerInterface::class] = [
    'file' => __DIR__ . '/../tmp/logs/' . $filename,
    'stream' => __DIR__ . '/../tmp/logs/' . $filename, // in aws is prefixed with s3://
];

$config[FilesystemInterface::class] = [
    'root' => __DIR__ . '/../data',
    'nagios' => __DIR__ . '/../data/nagios',
];

$config[NagiosInterface::class] = [
    'config_root' => '/usr/local/nagios/etc/',
    'object_root' => '/usr/local/nagios/etc/objects/',
    'main_config' => '/usr/local/nagios/etc/nagios.cfg',
];

$config[SessionInterface::class] = [
    'key' => '/config/private.pem', // needs to be generated
    'timeout' => 1200, // two hours
];

return $config;
