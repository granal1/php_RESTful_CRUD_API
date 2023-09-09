<?php

use Granal1\RestfulPhp\api\Item;
use PHPUnit\Framework\TestCase;

/**
 * @covers Granal1\RestfulPhp\api\Item
 */
final class ItemValidationExceptionTest extends TestCase
{
    protected static $item;

    public static function setUpBeforeClass(): void
    {
        self::$item = new Item;
    }

    public function testSetIdThrowValidationException(): void
    {
        $data = 12345678901;

        $this->expectExceptionMessage('id = ' . $data . ' - uncorrect; ');
        self::$item->setId($data);
    }


    public function testSetNameThrowValidationException(): void
    {
        $data = 'Wrong_Name';

        $this->expectExceptionMessage('name = ' . $data . ' - uncorrect; ');
        self::$item->setName($data);
    }


    public function testSetPhoneThrowValidationException(): void
    {
        $data = 'Wrong_Phone_Number';

        $this->expectExceptionMessage('phone = ' . $data . ' - uncorrect; ');
        self::$item->setPhone($data);
    }


    public function testSetKeyThrowValidationException(): void
    {
        $data = 'Wrong+Key+String';

        $this->expectExceptionMessage('key = ' . $data . ' - uncorrect; ');
        self::$item->setKey($data);
    }


    public function testSetHistoryThrowValidationException(): void
    {
        $data = 'Wrong_*_history';

        $this->expectExceptionMessage('history = ' . $data . ' - uncorrect; ');
        self::$item->setHistory($data);
    }


    public function testSetCreatedAtThrowValidationException(): void
    {
        $data = 'Wrong_date';

        $this->expectExceptionMessage('created_at = ' . $data . ' - uncorrect; ');
        self::$item->setCreated_at($data);
    }


    public function testSetUpdatedAtThrowValidationException(): void
    {
        $data = 'Wrong_date';

        $this->expectExceptionMessage('updated_at = ' . $data . ' - uncorrect; ');
        self::$item->setUpdated_at($data);
    }


    public function testSetDeletedAtThrowValidationException(): void
    {
        $data = 'Wrong_date';

        $this->expectExceptionMessage('deleted_at = ' . $data . ' - uncorrect; ');
        self::$item->setDeleted_at($data);
    }


}
