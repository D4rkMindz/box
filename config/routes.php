<?php

use Slim\App;

return static function (App $app) {
    $app->get('/', 'App\Controller\IndexController:indexAction')->setName('root');
    $app->get('/login', 'App\Controller\AuthController:indexAction')->setName('auth');
};
