<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require "../vendor/autoload.php";

use Granal1\RestfulPhp\api\Authorization;
use Granal1\RestfulPhp\Request;
use Granal1\RestfulPhp\api\Route;
use Exception;
use Granal1\RestfulPhp\SuccessfulResponse;
use Granal1\RestfulPhp\ErrorResponse;

header("Accept: application/json,text/*;q=0.99");
header("Content-Type: application/json; charset=utf-8");

$request = new Request($_SERVER, $_GET);

try {
    $authorized = (new Authorization())->check($request->token());
    $ApiClass = Route::getApiClass($request->apiName());
    $result = Route::startMethod($ApiClass, $request->apiMethod(), $request->parameters());
} catch (Exception $e) {
    (new ErrorResponse('error', $e->getMessage(), $e->getCode()))->send();
    return;
}

$response = new SuccessfulResponse($result['message'], [
    $request->apiName() => json_decode($result['data']),
]);
$response->send();
