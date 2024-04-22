<?php

namespace App\Classes;

use App\Interfaces\MyCustomResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class MyResponse extends Response implements MyCustomResponseInterface
{
    /**
     * @param int $code
     * @param string $reasonPhrase
     * @return ResponseInterface
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        $res = new MyResponse($code);

        if ('' !== $reasonPhrase) {
            $res = $res->withStatus($code, $reasonPhrase);
        }

        return $res;
    }

    /**
     * @param $data
     * @return ResponseInterface
     */
    public function withJson($data): ResponseInterface
    {
        return $this->jsonOutput([
            'success' => true,
            'result' => $data,
        ]);
    }

    /**
     * @param string $message
     * @param int $code
     * @return ResponseInterface
     */
    public function withError(string $message = 'Error not specified', int $code = 400): ResponseInterface
    {
        return $this->jsonOutput([
            'error' => [
                'http_code' => $code,
                'message' => $message,
            ],
        ])->withStatus($code);
    }

    /**
     * @param $data
     * @return ResponseInterface
     */
    public function jsonOutput($data): ResponseInterface
    {
        $json = json_encode($data);
        self::getBody()->write($json);

        return self::withHeader('Content-Type', 'application/json');
    }
}
