<?php

use App\Controllers\BaseController;
use App\Controllers\UserController;
use App\Middleware\XApiKeyMiddleware;
use DI\Container;

require __DIR__.'/../vendor/autoload.php';

$container = new Container();

$app = require __DIR__.'/../bootstrap/container.php';

$app->addErrorMiddleware(true, true, true);

$app->get('/', [BaseController::class, 'index']);

$app->get('/user/{id}', [BaseController::class, 'getUser']);

$app->get('/users-list', [UserController::class, 'getUsers']);

$app->get('/users[/{idOrLast}]', UserController::class)->add(new XApiKeyMiddleware());

$app->run();
