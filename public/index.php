<?php

use App\Controllers\BaseController;
use App\Services\UsersService;
use DI\Bridge\Slim\Bridge;
use DI\Container;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();

$container->set('UsersService', function () {
    return new UsersService();
});

$app = Bridge::create($container);

$app->addErrorMiddleware(true, true, true);

$app->get('/', [BaseController::class, 'index']);

$app->get('/user/{id}', [BaseController::class, 'getUser']);

$app->run();
