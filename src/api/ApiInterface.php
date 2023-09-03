<?php

namespace Granal1\RestfulPhp\api;

interface ApiInterface
{
    public function get(array $parameters);
    public function post(array $parameters);
    public function delete(array $parameters);
    public function update(array $parameters);
    public function responseMessage();
}