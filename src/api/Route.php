<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\MethodException;
use Granal1\RestfulPhp\Exceptions\RequestUriException;

class Route
{
    
    public static function getApiClass(string $apiName): ApiInterface
    {
        switch ($apiName) { //Если понадобится не только item, регистрировать здесь
            case "item":
                $apiClass = SourceApi::create('ItemApi');
                break;
            default:
                throw new RequestUriException($apiName . ' - Bad Request', 400);
        }

        return $apiClass;
    }


    public static function startMethod(ApiInterface $apiClass, string $method, array $parameters)
    {
        method_exists($apiClass, $method) ?
        $result = $apiClass->$method($parameters) :
        throw new MethodException($method . ' -  Method Not Allowed', 405);

        return [
            'message' => (string)$apiClass->responseMessage(), 
            'data' => $result
        ];
    }
}