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
        $item = new Item();

        $result = $item->setId($id);
        $this->assertEquals($id, $item->getId());
    }


    public function testItemSetAndGetName(): void
    {
        $name = 'Name'; 
        $item = new Item();

        $result = $item->setName($name);
        $this->assertEquals($name, $item->getName());
    }


    public function testItemSetAndGetPhone(): void
    {
        $phone = '111-11-11'; 
        $item = new Item();

        $result = $item->setPhone($phone);
        $this->assertEquals($phone, $item->getPhone());
    }


    public function testItemSetAndGetKey(): void
    {
        $key = 'newKey'; 
        $item = new Item();

        $result = $item->setKey($key);
        $this->assertEquals($key, $item->getKey());
    }


    public function testItemSetAndGetHistory(): void
    {
        $history = 'newHistory';
        $item = new Item();

        $result = $item->setHistory($history);
        $this->assertEquals($history, $item->getHistory());
    }


    public function testItemSetAndGetCreatedAt(): void
    {
        $date = '2000-01-01 00:00:00';
        $item = new Item();

        $result = $item->setCreated_at($date);
        $this->assertEquals($date, $item->getCreated_at());
    }


    public function testItemSetAndGetUpdatedAt(): void
    {
        $date = '2000-01-01 00:00:00';
        $item = new Item();

        $result = $item->setUpdated_at($date);
        $this->assertEquals($date, $item->getUpdated_at());
    }

    public function testItemSetAndGetDeletedAt(): void
    {
        $date = '2000-01-01 00:00:00';
        $item = new Item();

        $result = $item->setDeleted_at($date);
        $this->assertEquals($date, $item->getDeleted_at());
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

        $result = (string) $item;
        $this->assertEquals($example, $result);
    }
}
