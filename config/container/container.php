<?php

use App\Service\Nagios\NagiosFilesystem;
use App\Service\Nagios\NagiosInterface;
use App\Service\Settings;
use App\Service\SettingsInterface;
use Cake\Database\Connection;
use Cake\Database\Driver\Mysql;
use Dflydev\FigCookies\Modifier\SameSite;
use Dflydev\FigCookies\SetCookie;
use Fullpipe\TwigWebpackExtension\WebpackExtension;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Monolog\Formatter\HtmlFormatter;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\WebProcessor;
use Odan\Twig\TwigTranslationExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use PSR7Sessions\Storageless\Session\SessionInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Symfony\Component\Translation\Loader\MoFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Loader\FilesystemLoader;

/**
 * @return Settings
 */
$container[SettingsInterface::class] = static function () {
    $settings = require __DIR__ . '/../config.php';

    return new Settings($settings);
};

/**
 * @param ContainerInterface $container
 *
 * @return App
 */
$container[App::class] = static function (ContainerInterface $container) {
    AppFactory::setContainer($container);
    $app = AppFactory::create();

    return $app;
};

/**
 * @param App $app
 *
 * @return ResponseFactoryInterface
 */
$container[ResponseFactoryInterface::class] = static function (App $app) {
    return $app->getResponseFactory();
};

/**
 * Session middleware
 *
 * @param FilesystemInterface $filesystem
 * @param SettingsInterface   $settings
 *
 * @return SessionMiddleware
 */
$container[SessionMiddleware::class] = static function (FilesystemInterface $filesystem, SettingsInterface $settings) {
    $config = $settings->get(SessionInterface::class);
    $private = $filesystem->read($config['key']);
    $public = $filesystem->read($config['public']);

    return new SessionMiddleware(
        new Sha256(),
        $private,
        $public,
        SetCookie::create(SessionMiddleware::DEFAULT_COOKIE)
            ->withSecure(true)
            ->withHttpOnly(false)
            ->withSameSite(SameSite::lax())
            ->withPath('/'),
        new Parser(),
        $config['timeout'],
        new SystemClock()
    );
};

/**
 * Twig container.
 *
 * @param SettingsInterface $settings
 *
 * @return Twig
 */
$container[Twig::class] = static function (SettingsInterface $settings, App $app): Twig {
    $twigSettings = $settings->get('twig');
    $twig = new Twig(
        $twigSettings['path'], [
        'cache' => $twigSettings['cache']['enabled'] ? $twigSettings['cache']['path'] : false,
        'auto_reload' => $twigSettings['autoReload'],
    ]);
    $loader = $twig->getLoader();
    if ($loader instanceof FilesystemLoader) {
        $loader->addPath($settings->get('public'), 'templates');
    }
    $environment = $twig->getEnvironment();
    // Add relative base url
    $basePath = $app->getBasePath();
    $environment->addGlobal('base_path', $basePath . '/');

    // Add Twig extensions
    $twig->addExtension(new TwigTranslationExtension());
    $twig->addExtension(new WebpackExtension(
    // must be a absolute path
        $settings->get('public') . '/assets/manifest.json',
        // url path for js
        $basePath . '/assets/',
        // url path for css
        $basePath . '/assets/'
    ));

    return $twig;
};

/**
 * HTTP Client
 *
 * @param SettingsInterface $settings
 *
 * @return ClientInterface
 */
$container[ClientInterface::class] = static function (SettingsInterface $settings): ClientInterface {
    $config = $settings->get(ClientInterface::class);

    return new Client(['base_uri' => $config['base_uri']]);
};

/**
 * Translator container.
 *
 * @param SettingsInterface $settings
 *
 * @return Translator $translator
 */
$container[Translator::class] = static function (SettingsInterface $settings): Translator {
    $config = $settings->get(Translator::class);
    $translator = new Translator($config['locale']);
    $translator->addLoader('mo', new MoFileLoader());

    return $translator;
};

/**
 * Database connection container.
 *
 * @param SettingsInterface $settings
 *
 * @return Connection
 */
$container[Connection::class] = static function (SettingsInterface $settings): Connection {
    $config = $settings->get('db');
    $driver = new Mysql([
        'host' => $config['host'],
        'port' => $config['port'],
        'database' => $config['database'],
        'username' => $config['username'],
        'password' => $config['password'],
        'encoding' => $config['encoding'],
        'charset' => $config['charset'],
        'collation' => $config['collation'],
        'prefix' => '',
        'flags' => [
            // Enable exceptions
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Set default fetch mode
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_unicode_ci",
        ],
    ]);
    $driver->enableAutoQuoting(true);
    $db = new Connection([
        'driver' => $driver,
    ]);

    $db->connect();

    return $db;
};

/**
 * Logger container
 *
 * @param SettingsInterface   $settings
 * @param FileSystemInterface $fileSystem
 *
 * @return Logger
 */
$container[LoggerInterface::class] = static function (SettingsInterface $settings, FileSystemInterface $fileSystem) {
    $name = $settings->get('name');
    $config = $settings->get(LoggerInterface::class);

    // make sure that the file system is called and set up.
    // https://stackoverflow.com/questions/24271489/configure-php-monolog-to-log-to-amazon-s3-via-stream
    // https://stackoverflow.com/a/24272614/6805097
    // formerly it was $container->get(FileSystemInterface::class). This is to remove the container dependency
    $fileSystem->has('/');
    $logger = new Monolog\Logger($name);

    $log = new StreamHandler($config['stream'] . '.log');
    $log->setFormatter(new LineFormatter());
    $logger->pushHandler($log);

    $html = new StreamHandler($config['stream'] . '.html');
    $html->setFormatter(new HtmlFormatter());
    $logger->pushHandler($html);

    $json = new StreamHandler($config['stream'] . '.json');
    $json->setFormatter(new JsonFormatter());
    $logger->pushHandler($json);

    $logger->pushProcessor(new PsrLogMessageProcessor());
    $logger->pushProcessor(new IntrospectionProcessor());
    $logger->pushProcessor(new WebProcessor());
    $logger->pushProcessor(new MemoryUsageProcessor());
    $logger->pushProcessor(new MemoryPeakUsageProcessor());

    return $logger;
};

/**
 * Filesystem container.
 *
 * @param SettingsInterface $settings
 *
 * @return Filesystem
 */
$container[FileSystemInterface::class] = static function (SettingsInterface $settings) {
    $config = $settings->get(FileSystemInterface::class);

    return new FileSystem(new Local($config['root']));
};

/**
 * Nagios Filesystem interface.
 *
 * @param SettingsInterface $settings
 *
 * @return NagiosFilesystem
 */
$container[NagiosFilesystem::class] = static function (SettingsInterface $settings) {
    $config = $settings->get(NagiosInterface::class);

    return new NagiosFilesystem(new Local($config['nagios_root']));
};
