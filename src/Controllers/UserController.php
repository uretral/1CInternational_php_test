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
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface|UsersListService
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
     * @param Request $request
     * @param Response $response
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getUsers(Request $request, Response $response): ResponseInterface
    {
        $usersListService = $this->usersListService($request, $response);
        return $this->withJson($request, $response, $usersListService->getUsers())->withStatus(200);
    }

    /**
     *  #4 - add new optional route with three methods
     *
     * @param Request $request
     * @param Response $response
     * @param mixed|null $idOrLast
     * @return ResponseInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, Response $response, mixed $idOrLast = null): ResponseInterface
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

    /**
     * #5 - add error handling
     *
     * @param Request $request
     * @param Response $response
     * @param Collection $collection
     * @return ResponseInterface
     */
    public function getCollection(Request $request, Response $response, Collection $collection): ResponseInterface
    {
        return $collection->count()
            ? $this->withJson($request, $response, $collection)->withStatus(200)
            : $this->respondWithError($request, $response, 'There is no one user yet');
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Collection $collection
     * @param int $id
     * @return ResponseInterface
     */
    public function getCollectionItemByID(Request $request, Response $response, Collection $collection, int $id): ResponseInterface
    {
        if ($item = $collection->where('id', $id)->first()) {
            return $this->withJson($request, $response, $item)->withStatus(200);
        }

        return $this->errorWrongArgs($request, $response,
            "User with ID {$id} not found, only {$collection->pluck('id')->toJson()} ID`s are available");
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Collection $collection
     * @return ResponseInterface
     */
    public function getCollectionItemByRegDate(Request $request, Response $response, Collection $collection): ResponseInterface
    {
        if ($item = $collection->sortByDesc('REG_DATE')->first()) {
            return $this->withJson($request, $response, $item)->withStatus(200);
        }

        return $this->respondWithError($request, $response, 'There is no one user yet');
    }

}
