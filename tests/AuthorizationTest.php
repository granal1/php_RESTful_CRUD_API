<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\Authorization;

/**
 * @covers Granal1\RestfulPhp\api\Authorization
 */
final class AuthorizationTest extends TestCase
{
    public function testAuthorizationPass(): void
    {
        $tokens = require dirname(__DIR__, 1) . '/config/apiTokens.php';
        $token = $tokens[0];
        $sample = $tokens[0];

        $authorization = new Authorization();

        $this->assertEquals($sample, $authorization->check($token));
    }


    public function testAuthorizationFailed(): void
    {
        $token = 'wrongToken';

        $authorization = new Authorization();

        $this->expectExceptionMessage('Unauthorized user');
        $result = $authorization->check($token);
    }
}