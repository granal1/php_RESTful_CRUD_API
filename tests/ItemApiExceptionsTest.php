<?php

use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\ItemApi;
use Granal1\RestfulPhp\Exceptions\DBException;

/**
 * @covers Granal1\RestfulPhp\api\ItemApi
 * @uses Granal1\RestfulPhp\api\Item
 * @uses Granal1\RestfulPhp\api\Database
 * @uses Granal1\RestfulPhp\api\ItemApi
 * @uses Granal1\RestfulPhp\api\SourceApi
 */
final class ItemApiExceptionsTest extends TestCase
{
    protected static $pdo;
    protected static $dbConfig;
    protected $itemApi;
    protected $parameters;
 

    public static function setUpBeforeClass(): void
    {
        $dbConfigFile = dirname(__DIR__, 1) . '/config/app.ini';
        
        if(!is_file($dbConfigFile)){
            throw new DBException('DB connection error. Settings not found', 503);
        }
        self::$dbConfig = parse_ini_file($dbConfigFile);

        self::$pdo = new PDO(
            'mysql:host='.self::$dbConfig['host'].
            ';dbname='.self::$dbConfig['test_db_name'], 
            self::$dbConfig['db_user'], 
            self::$dbConfig['db_password']
        );
    }


    protected function setUp(): void
    {
        // настройка тестовой базы данных
        $this->itemApi = new ItemApi(self::$pdo);
        self::$pdo->query("DROP TABLE IF EXISTS `item`");
    }


    public function testItemApiGetMethodListDataFailed(): void
    {
        $id = ['id' => '0900070000'];
        $this->expectExceptionMessage(
            "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'php_restful_api_for_tests.item' doesn't exist"
        );
        $result = $this->itemApi->get($id);
    }


    public function testItemApiGetMethodFailed(): void
    {
        $id = ['id' => '1'];
        $this->expectExceptionMessage(
            "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'php_restful_api_for_tests.item' doesn't exist"
        );
        $result = $this->itemApi->get($id);
    }


    public function testItemApiPostMethodFailed(): void
    {
        $parameters = [
            'name' => 'mrSecond',
            'phone' => '2(222)222-22-22',
            'key' => 'key222',
        ];
        $this->expectExceptionMessage(
            "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'php_restful_api_for_tests.item' doesn't exist"
        );
        $result = $this->itemApi->post($parameters);
    }


    public function testItemApiUpdateMethodFailed(): void
    {
        self::$pdo->query("CREATE TABLE `item` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `key` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `history` json DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        self::$pdo->query(
            'INSERT INTO `item`
            SET
                `name` = "mrFirst",
                `phone` = "1(111)111-11-11",
                `key` = "key111",
                `created_at` = date("2000-01-01 00:00:00"), 
                `updated_at` = date("2000-01-01 00:00:00")'
        );

        $parameters = [
            'id' => 1,
            'name' => 'Name Is To Long'
        ];
        $this->expectExceptionMessage(
            "SQLSTATE[22001]: String data, right truncated: 1406 Data too long for column 'name' at row 1"
        );
        $result = $this->itemApi->update($parameters);
    }


    public function testItemApiDeleteMethodFailed(): void
    {
        $id = ['id' => '1'];
        $this->expectExceptionMessage(
            "SQLSTATE[42S02]: Base table or view not found: 1146 Table 'php_restful_api_for_tests.item' doesn't exist"
        );
        $result = $this->itemApi->delete($id);
    }


    protected function tearDown(): void
    {
        $this->itemApi = null;
    }

    
    public static function tearDownAfterClass(): void
    {
        self::$pdo->query("DROP TABLE IF EXISTS `item`");
        self::$pdo = null;
    }
}