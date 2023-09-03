<?php

namespace Granal1\RestfulPhp;

abstract class Response
{
    protected int $responseCode;
    protected string $message;
    
    
    public function send(): void
    {
        $data = ['message' => $this->message] + $this->payload();

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($this->responseCode);
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    
    abstract protected function payload(): array;
}