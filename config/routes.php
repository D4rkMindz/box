<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\ExceptionApiMiddleware;
use App\Middleware\ExceptionMiddleware;
use App\Middleware\LanguageMiddleware;
use PSR7Sessions\Storageless\Http\SessionMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {
    $container = $app->getContainer();
    $app->group('', function (RouteCollectorProxy $group) {
        $group->get('/', 'App\Controller\IndexController:indexAction')->setName('root');
        $group->get('/login', 'App\Controller\AuthController:indexAction')->setName('auth');
        $group->post('/login', 'App\Controller\AuthController:loginAction')->setName('auth.login');
        $group->get('/logout', 'App\Controller\AuthController:logoutAction')->setName('auth.logout');
        $group->get('/admin', 'App\Controller\AdminController:indexAction')->setName('admin');
    })
        ->addMiddleware($container->get(ExceptionMiddleware::class))
        ->addMiddleware($container->get(LanguageMiddleware::class))
        ->addMiddleware($container->get(AuthMiddleware::class))
        ->addMiddleware($container->get(SessionMiddleware::class));

    $app->group('/api', function (RouteCollectorProxy $group) {
        $group->post('/objects', 'App\Controller\API\ObjectController:createObjectAction')
            ->setName('api.object.create');
    })
        ->addMiddleware($container->get(ExceptionApiMiddleware::class))
        ->addMiddleware($container->get(LanguageMiddleware::class))
        ->addMiddleware($container->get(AuthMiddleware::class))
        ->addMiddleware($container->get(SessionMiddleware::class));;
};
