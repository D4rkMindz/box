<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\ExceptionMiddleware;
use App\Middleware\LanguageMiddleware;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use Slim\App;

return static function (App $app) {
    $container = $app->getContainer();

    $app->addMiddleware($container->get(ExceptionMiddleware::class));
    $app->addMiddleware($container->get(LanguageMiddleware::class));
    $app->addMiddleware($container->get(AuthMiddleware::class));
    $app->addMiddleware($container->get(SessionMiddleware::class));
    $app->addRoutingMiddleware();

    $app->addBodyParsingMiddleware();
};
