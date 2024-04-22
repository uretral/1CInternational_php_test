<?php

namespace App\Controllers;

use App\Services\UsersListService;
use Illuminate\Support\Collection;
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

    /**
     * #4 - add new optional route with three methods
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response, mixed $idOrLast = null)
    {
        $usersListService = $this->usersListService($request, $response);

        return $usersListService->getUsers()->when(is_null($idOrLast),
            function (Collection $collection) use ($request, $response) {
                return $this->getCollection($request, $response, $collection);
            },
            function (Collection $collection) use ($request, $response, $idOrLast) {
                return is_numeric($idOrLast)
                    ? $this->getCollectionItemByID($request, $response, $collection, $idOrLast)
                    : $this->getCollectionItemByRegDate($request, $response, $collection);
            });
    }

    public function getCollection(Request $request, Response $response, Collection $collection): ResponseInterface
    {
        return $this->withJson($request, $response, $collection)->withStatus(200);
    }

    public function getCollectionItemByID(Request $request, Response $response, Collection $collection, int $id): ResponseInterface
    {
        return $this->withJson($request, $response, $collection->where('id', $id)->first())->withStatus(200);
    }

    public function getCollectionItemByRegDate(Request $request, Response $response, Collection $collection): ResponseInterface
    {
        return $this->withJson($request, $response, $collection->sortByDesc('REG_DATE')->first())->withStatus(200);
    }

}
