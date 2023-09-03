<?php

namespace Granal1\RestfulPhp\api;

abstract class SourceApi implements ApiInterface
{
    public static function create(string $apiName,  $connection = null)
    {
        $apiName = __NAMESPACE__ .'\\'. $apiName;
        return new $apiName($connection);
    }

    abstract public function get(array $parameters);
    abstract public function post(array $parameters);
    abstract public function delete(array $parameters);
    abstract public function update(array $parameters);
    abstract public function responseMessage();
}