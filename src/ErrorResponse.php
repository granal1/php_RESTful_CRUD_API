<?php

namespace Granal1\RestfulPhp;

class ErrorResponse extends Response
{
    public function __construct(
        protected string $message = 'error',
        private string $reason = 'Something goes wrong',
        protected int $responseCode = 400
    ) {
    }

    
    protected function payload(): array
    {
        return ['reason' => $this->reason];
    }
}