<?php

namespace App\Middleware;


use App\Errors\MyUnauthorizedException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class XApiKeyMiddleware
{

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if ($request->hasHeader('X-api-key')) {
            return $response;
        }

        throw new MyUnauthorizedException($request);
    }
}
