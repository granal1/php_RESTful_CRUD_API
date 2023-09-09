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
final class ItemApiTest extends TestCase
{
    protected static $pdo;
    protected $itemApi;
    protected $parameters;
 

    public static function setUpBeforeClass(): void
    {
        $dbConfigFile = dirname(__DIR__, 1) . '/config/app.ini';
        
        if(!is_file($dbConfigFile)){
            throw new DBException('DB connection error. Settings not found', 503);
        }
        $dbConfig = parse_ini_file($dbConfigFile);

        self::$pdo = new PDO(
            'mysql:host='.$dbConfig['host'].
            ';dbname='.$dbConfig['test_db_name'], 
            $dbConfig['db_user'], 
            $dbConfig['db_password']
        );

        self::$pdo->query("DROP TABLE IF EXISTS `item`");
        self::$pdo->query("CREATE TABLE `item` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `key` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
            `history` json DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            `deleted_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }


    protected function setUp(): void
    {
        // настройка тестовой базы данных
        
        $this->itemApi = new ItemApi(self::$pdo);

        $statement = self::$pdo->query("TRUNCATE TABLE `item`");
        $statement = self::$pdo->query(
            'INSERT INTO `item`
            SET
                `name` = "mrFirst",
                `phone` = "1(111)111-11-11",
                `key` = "key111",
                `created_at` = date("2000-01-01 00:00:00"), 
                `updated_at` = date("2000-01-01 00:00:00")'
        );
    }


    public function testItemApiPostMethodAddData()
    {
        $this->parameters = [
            'name' => 'mrSecond',
            'phone' => '2(222)222-22-22',
            'key' => 'key222',
        ];
        $example = $this->parameters['key'];
        
        $result = $this->itemApi->post($this->parameters);
        $result = json_decode($result, true);

        $this->assertSame($example, $result['key']);
        $this->assertSame('post successful', $this->itemApi->responseMessage());
    }


    public function testItemApiGetMethodReturnData(): void
    {
        $id = ['id' => 1];
        $example = [
            'id' => 1,
            'name' => 'mrFirst',
            'phone' => '1(111)111-11-11',
            'key' => 'key111',
            'history' => null,
            'created_at' => '2000-01-01 00:00:00', 
            'updated_at' => '2000-01-01 00:00:00'
        ];

        $result = $this->itemApi->get($id);
        $result = json_decode($result, true);

        $this->assertSame($example, $result);
        $this->assertSame('successful', $this->itemApi->responseMessage());
    }


    public function testItemApiGetMethodListDataFailed(): void
    {
        $id = ['id' => '0900070000'];
        $statement = self::$pdo->prepare("TRUNCATE TABLE `item`");
        $statement->execute();

        $this->expectExceptionMessage('Item not found');
        $result = $this->itemApi->get($id);
    }

    
    public function testItemApiGetMethodItemNotFound(): void
    {
        $id = ['id' => 10];

        $this->expectExceptionMessage('Item not found');
        $result = $this->itemApi->get($id);
    }


    public function testItemApiUpdateMethodWorks()
    {
        $this->parameters = [
            'id' => 1,
            'name' => 'mrSecond',
            'phone' => '2(222)222-22-22',
            'key' => 'key222',
        ];
        $example = [
            'id' => 1,
            'name' => 'mrSecond',
            'phone' => '2(222)222-22-22',
            'key' => 'key222',
            'history' => [
                [
                    'key' => 'key111',
                    'name' => 'mrFirst',
                    'phone' => '1(111)111-11-11',
                    'updated_at' => '2000-01-01 00:00:00'
                ]
            ],
            'created_at' => '2000-01-01 00:00:00',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->itemApi->update($this->parameters);
        $result = json_decode($result, true);

        $this->assertSame($example, $result);
        $this->assertSame('update successful', $this->itemApi->responseMessage());
    }


    public function testItemApiDeleteMethodWorks()
    {
        $this->parameters = ['id' => 1];
        $example = '';
        
        $result = $this->itemApi->delete($this->parameters);

        $this->assertSame($example, $result);
        $this->assertSame('successful deleted', $this->itemApi->responseMessage());
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