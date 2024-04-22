<?php

namespace App\Controllers;

use App\Services\UsersService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Uru\SlimApiController\ApiController;

class BaseController extends ApiController
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Response $response): ResponseInterface
    {
        $response->getBody()->write('<a href="/user/1">User info</a>');

        return $response->withStatus(200);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUser(int $id, Request $request, Response $response): ResponseInterface
    {
        /** @var UsersService $usersService */
        $usersService = $this->container->has('UsersService') ? $this->container->get('UsersService') : null;
        $user = $usersService->createUser($id)->getUser();

        return $this->withJson($request, $response, [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ])->withStatus(200);
    }
}
