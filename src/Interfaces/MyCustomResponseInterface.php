<?php

namespace App\Interfaces;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

interface MyCustomResponseInterface extends ResponseFactoryInterface
{
    /**
     * @param mixed $data
     * @return ResponseInterface
     */
    public function withJson(mixed $data): ResponseInterface;

    /**
     * @param string $message
     * @param int $code
     * @return ResponseInterface
     */
    public function withError(string $message, int $code): ResponseInterface;
}
