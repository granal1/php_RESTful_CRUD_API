<?php

use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\Route;
use Granal1\RestfulPhp\api\ItemApi;

/**
 * @covers Granal1\RestfulPhp\api\Route
 * @covers Granal1\RestfulPhp\api\SourceApi
 * @uses Granal1\RestfulPhp\api\ItemApi
 * @uses Granal1\RestfulPhp\api\Database
 */
final class RouteItemTest extends TestCase
{
    public function testRouteGetApiClassCreateApiObject(): void
    {
        $apiName = 'item';

        $result = Route::getApiClass($apiName);
        $this->assertInstanceOf(ItemApi::class, $result);
    }


    public function testRouteGetApiClassWrongApiException(): void
    {
        $apiName = 'wrongApiName';

        $this->expectExceptionMessage($apiName . ' - Bad Request');
        $result = Route::getApiClass($apiName);
    }


    public function testRouteStartMethodReturnData(): void
    {
        $method = 'GET';
        $parameters = [
            'id' => 1,
        ];
        $example = [
            'message' => '',
            'data' => 'dataFromDb'
        ];

        $apiClassMock = $this->createMock(ItemApi::class);
        $apiClassMock->expects($this->once())
        ->method('get')
        ->with($parameters)
        ->willReturn('dataFromDb');
        
        $result = Route::startMethod($apiClassMock, $method, $parameters);
        $this->assertEquals($example, $result);
    }

    public function testRouteStartMethodWrongMethodException(): void
    {
        $method = 'WRONG_METHOD';
        $parameters = [];

        $apiClassMock = $this->createMock(ItemApi::class);
        
        $this->expectExceptionMessage($method . ' -  Method Not Allowed');
        $result = Route::startMethod($apiClassMock, $method, $parameters);
    }
}