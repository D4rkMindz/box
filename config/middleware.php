<?php

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return static function (App $app) {
    $app->addMiddleware(TwigMiddleware::createFromContainer($app, Twig::class));
    $app->addRoutingMiddleware();

    $app->addBodyParsingMiddleware();
};
