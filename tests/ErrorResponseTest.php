<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\ErrorResponse;


/**
 * @covers Granal1\RestfulPhp\ErrorResponse
 * @covers Granal1\RestfulPhp\Response
 */
final class ErrorResponseTest extends TestCase
{
    public function testErrorResponsePrintsCorrectly(): void
    {
        $message = 'testError';
        $reason = 'test error prints correctly';
        $responseCode = 400;
        $response = new ErrorResponse($message, $reason, $responseCode);

        $this->expectOutputString('{"message":"testError","reason":"test error prints correctly"}');
        $response->send();
    }
}
