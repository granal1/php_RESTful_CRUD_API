<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\Request;


/**
 * @covers Granal1\RestfulPhp\Request
 */
final class RequestTest extends TestCase
{
    public function testRequestHasToken(): void
    {
        $result = 'fe1386814d3f44d4e7';
        $server = ['HTTP_AUTHORIZATION' => 'Bearer fe1386814d3f44d4e7'];
        $get = [];
        $request = new Request($server, $get);

        $this->assertEquals($result, $request->token());
    }


    public function testRequestDoesHaveAuthorizationNotBearer(): void
    {
        $server = ['HTTP_AUTHORIZATION' => 'fe1386814d3f44d4e7'];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('Unauthorized user');
        $result = $request->token();
    }


    public function testRequestDoesNotHaveAuthorization(): void
    {
        $server = [];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('Unauthorized user');
        $result = $request->token();
    }


    public function testParametersIsReceived(): void
    {
        $server = [];
        $get = ['id' => 20];
        $result = $get;
        $request = new Request($server, $get);

        $this->assertEquals($result, $request->parameters());
    }


    public function testParametersMissing(): void
    {
        $server = [];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('There are no parameters in your request');
        $result = $request->parameters();
    }


    public function testApiNameCorrect(): void
    {
        $server = ['REQUEST_URI' => '/api/item?id=1'];
        $get = [];
        $result = 'item';
        $request = new Request($server, $get);

        $this->assertEquals($result, $request->apiName());
    }


    public function testApiNameAbsent(): void
    {
        $server = ['REQUEST_URI' => '/api?id=1'];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('/api - Bad Request');
        $result = $request->apiName();
    }


    public function testApiNameWrong(): void
    {
        $server = ['REQUEST_URI' => '/apo/item?id=1'];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('/apo/item - Bad Request');
        $result = $request->apiName();
    }


    public function testMethodIsCorrect(): void
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $get = [];
        $result = 'post';
        $request = new Request($server, $get);

        $this->assertEquals($result, $request->apiMethod());
    }


    public function testMethodIsAbsent(): void
    {
        $server = [];
        $get = [];
        $request = new Request($server, $get);

        $this->expectExceptionMessage('Method not allowed or absent');
        $result = $request->apiMethod();
    }
}
