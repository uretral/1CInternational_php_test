<?php

use App\Interfaces\UserInterface;
use App\Services\UsersListService;
use App\Services\UsersService;
use DI\Bridge\Slim\Bridge;
use DI\Container;
use Psr\Http\Message\ResponseFactoryInterface;

$container = new Container();

$container->set(ResponseFactoryInterface::class, fn () => new App\Classes\MyResponse());

$container->set('UsersService', fn () => new UsersService());

$container->set(UserInterface::class, fn () => new UsersListService());

return Bridge::create($container);
