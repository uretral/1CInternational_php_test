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
        return $this->container->has($this->serviceName)
            ? $this->container->get($this->serviceName)
            : $this->respondWithError($request, $response, 'Service unavailable', 503);
    }


    /**
     * #3 - create controller with service(#2) through DI
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUsers(Request $request, Response $response): ResponseInterface
    {
        $usersListService = $this->usersListService($request, $response);
        return $this->withJson($request, $response, $usersListService->getUsers())->withStatus(200);
    }

}
