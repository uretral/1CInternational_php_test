<?php

namespace App\Controllers;

use App\Services\UsersListService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Uru\SlimApiController\ApiController;

class UserController extends ApiController
{

    private ContainerInterface $container;
    private string $serviceName = 'UsersListService';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function usersListService(Request $request, Response $response): ResponseInterface|UsersListService
    {
        if ($this->container->has($this->serviceName)) {
            return $this->container->get($this->serviceName);
        } else {
            return $this->respondWithError($request, $response, 'Service unavailable',503);
        }
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUsers(Request $request, Response $response): ResponseInterface
    {
        $usersListService = $this->usersListService($request, $response);
        return $this->withJson($request, $response, $usersListService->getUsers())->withStatus(200);
    }

}
