<?php

namespace Granal1\RestfulPhp;

use Granal1\RestfulPhp\Exceptions\AuthException;
use Granal1\RestfulPhp\Exceptions\ParametersException;
use Granal1\RestfulPhp\Exceptions\RequestUriException;

class Request
{
    private $token;

    public function __construct(
        private array $server,
        private array $get
        ) {
    }


    public function token(): string
    {
        if (!array_key_exists('HTTP_AUTHORIZATION', $this->server)) {
            throw new AuthException('Unauthorized user', 401);
        }

        $this->token = explode(' ',  $this->server['HTTP_AUTHORIZATION']);
        if (count($this->token) < 2 || empty($this->token[1])) {
            throw new AuthException('Unauthorized user', 401);
        }

        return $this->token[1];
    }


    public function parameters(): array
    {
        if (empty($this->get)) {
            throw new ParametersException('There are no parameters in your request', 400);
        }

        return $this->get;
    }


    public function apiName(): string
    {
        $path = explode('?', $this->server['REQUEST_URI'])[0];
        $path = explode('/', $path);

        if (count($path) < 3 || $path[1] != 'api') {
            throw new RequestUriException(explode('?', $this->server['REQUEST_URI'])[0] . ' - Bad Request', 400);
        }

        return $path[2];
    }


    public function apiMethod(): string
    {
        if (!array_key_exists('REQUEST_METHOD', $this->server)) {
            throw new RequestUriException('Method not allowed or absent', 405);
        }

        $method = strtolower($this->server['REQUEST_METHOD']);
        $method = ($method !== 'put') ? $method : 'update';

        return $method;
    }
}