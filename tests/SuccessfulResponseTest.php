<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\SuccessfulResponse;

/**
 * @covers Granal1\RestfulPhp\SuccessfulResponse
 * @uses Granal1\RestfulPhp\Response
 */
final class SuccessfulResponseTest extends TestCase
{
    public function testSuccessfulResponsePrintsCorrectly(): void
    {
        $message = 'ok';
        $data = ['key' => 'value'];
        $responseCode = 200;
        $response = new SuccessfulResponse($message, $data, $responseCode);

        $this->expectOutputString('{"message":"ok","data":{"key":"value"}}');
        $response->send();
    }
}