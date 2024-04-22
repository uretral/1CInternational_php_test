<?php

namespace App\Middleware;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class XApiKeyMiddleware
{
    /**
     * @throws \ErrorException
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if ($request->hasHeader('X-api-key')) {
            return $response;
        }

        throw new \ErrorException('Unauthorized', 401);
    }
}
