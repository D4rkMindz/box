<?php

use DI\ContainerBuilder;
use Slim\App;
use Symfony\Component\Translation\Translator;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container/bootstrap.php');
$container = $containerBuilder->build();

$app = $container->get(App::class);

// Set up dependencies
require __DIR__ . '/../config/container/bootstrap.php';

// Register routes
$routeBuilder = require __DIR__ . '/../config/routes.php';
$routeBuilder($app);

// Register middlewares
$middlewareBuilder = require __DIR__ . '/../config/middleware.php';
$middlewareBuilder($app);

// set App
__($app->getContainer()->get(Translator::class));

return $app;
