<?php

use Slim\App;

return static function (App $app) {
    $app->get('/', 'App\Controller\IndexController:indexAction')->setName('root');
    $app->get('/login', 'App\Controller\AuthController:indexAction')->setName('auth');
    $app->post('/login', 'App\Controller\AuthController:loginAction')->setName('auth.login');
    $app->get('/logout', 'App\Controller\AuthController:logoutAction')->setName('auth.logout');
    $app->get('/admin', 'App\Controller\AdminController:indexAction')->setName('admin');
};
