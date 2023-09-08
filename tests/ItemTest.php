<?php


use PHPUnit\Framework\TestCase;
use Granal1\RestfulPhp\api\Item;

/**
 * @covers Granal1\RestfulPhp\api\Item
 */
final class ItemTest extends TestCase
{
    public function testItemSetAndGetId(): void
    {
        $id = 1; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setId(2);
        $this->assertEquals(2, $item->getId());
    }


    public function testItemSetAndGetName(): void
    {
        $id = '1'; 
        $name = 'oldName'; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setName('newName');
        $this->assertEquals('newName', $item->getName());
    }


    public function testItemSetAndGetPhone(): void
    {
        $id = '1'; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setPhone('111-11-11');
        $this->assertEquals('111-11-11', $item->getPhone());
    }


    public function testItemSetAndGetKey(): void
    {
        $id = '1'; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setKey('newKey');
        $this->assertEquals('newKey', $item->getKey());
    }


    public function testItemSetAndGetHistory(): void
    {
        $id = '1'; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setHistory('newHistory');
        $this->assertEquals('newHistory', $item->getHistory());
    }


    public function testItemSetAndGetCreatedAt(): void
    {
        $id = '1'; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setCreated_at('2000-01-01 00:00:00');
        $this->assertEquals('2000-01-01 00:00:00', $item->getCreated_at());
    }


    public function testItemSetAndGetUpdatedAt(): void
    {
        $id = '1'; 
        $name = ''; 
        $phone = ''; 
        $key = ''; 
        $created_at = ''; 
        $updated_at = '';
        $history = '';
        $item = new Item($id, $name, $phone, $key, $created_at, $updated_at, $history);

        $result = $item->setUpdated_at('2000-01-01 00:00:00');
        $this->assertEquals('2000-01-01 00:00:00', $item->getUpdated_at());
    }


    public function testItemToStringMethodReturnsString(): void
    {
        $id = '1'; 
        $name = 'Name'; 
        $phone = '1(111)111-11-11'; 
        $key = 'key111'; 
        $created_at = '2000-01-01 00:00:00'; 
        $updated_at = '2000-01-01 00:00:00';
        $history = '';

        $example = '{"id":1,"name":"Name","phone":"1(111)111-11-11","key":"key111","history":null,"created_at":"2000-01-01 00:00:00","updated_at":"2000-01-01 00:00:00"}';
        $item = (new Item())
                ->setId($id)
                ->setName($name)
                ->setPhone($phone)
                ->setKey($key)
                ->setCreated_at($created_at)
                ->setUpdated_at($updated_at)
                ->setHistory($history);

        $result = $item->__toString();
        $this->assertEquals($example, $result);
    }
}
