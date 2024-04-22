<?php

namespace App\Errors;

use Slim\Exception\HttpSpecializedException;

class MyUnauthorizedException extends HttpSpecializedException
{
    protected $code = 401;
    protected $message = 'Unauthorized';
    protected string $title = '401 Unauthorized';
    protected string $description = 'Access is allowed only to authorized users';
}
