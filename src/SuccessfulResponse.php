<?php

namespace Granal1\RestfulPhp;

class SuccessfulResponse extends Response
{
    public function __construct(
        protected string $message,
        private array $data = [],
        protected int $responseCode = 200
    ){
    }

    
    protected function payload(): array
    {
        return ['data' => $this->data];
    }
}