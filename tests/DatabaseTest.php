<?php

use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\Database;

/**
 * @covers Granal1\RestfulPhp\api\Database
 */
final class DatabaseTest extends TestCase
{
    public function testDatabaseConnected(): void
    {
        $result = Database::getConnection();

        $this->assertInstanceOf(PDO::class, $result);
    }

    public function testDatabaseConfigNotFound(): void
    {
        $this->expectExceptionMessage('DB connection error. Settings not found');
        
        $result = Database::getConnection('wrong_config');
    }

    public function testDatabaseConfigWrong(): void
    {
        $this->expectExceptionMessage('DB connection error');
        $filename = dirname(__DIR__, 1) . '/tests/DatabaseWrongExampleIni.ini';

        $result = Database::getConnection($filename);
    }
}