<?php

use App\Controllers\BaseController;
use App\Services\UsersService;
use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set('UsersService', function (ContainerInterface $container) {
    return (new UsersService());
});

$app->addErrorMiddleware(true, true, true);

$app->get('/', [BaseController::class, 'index']);

$app->get('/user/{id}', [BaseController::class, 'getUser']);

$app->run();
