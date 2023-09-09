<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\ItemException;
use PDO;
use PDOStatement;
use Exception;
use Granal1\RestfulPhp\Exceptions\DBException;
use Granal1\RestfulPhp\Exceptions\ParametersException;

class ItemApi extends SourceApi
{
    private $connection;
    private string $responseMessage = '';


    function __construct(PDO $connection = null)
    {
        $connection === null ? $connection = Database::getConnection() : $connection;
        $this->connection = $connection;
    }


    public function get(array $parameters)
    {
        $parameters['id'] = ($parameters['id']) ?? $parameters['id'] = 0;
        try {
            $statement = $this->connection->prepare(
                'SELECT * FROM item WHERE id = :id AND deleted_at IS NULL'
            );
            $statement->execute([
                ':id' => (int) $parameters['id']
            ]);
        } catch (Exception $e) {
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage .= 'successful';
        return $this->getItemFromDB($statement);
    }


    public function post(array $parameters)
    {
        $item = $this->getItemFromRequest($parameters);

        try {
            $statement = $this->connection->prepare(
                'INSERT INTO `item` 
                SET 
                    `name` = :name, 
                    `phone` = :phone, 
                    `key` = :key, 
                    `created_at` = :created_at, 
                    `updated_at` = :updated_at'
            );
            $statement->execute([
                ':name' => $item->getName(),
                ':phone' => $item->getPhone(),
                ':key' => $item->getKey(),
                ':created_at' => date('Y-m-d H:i:s'),
                ':updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage .= 'post ';
        $created['id'] = $this->connection->lastInsertId();
        return $this->get($created);
    }


    public function update(array $parameters)
    {
        $currentItem = $this->get($parameters);
        $newItem = $this->getItemFromRequest($parameters);

        $newHistory = [];
        $properties = ['name', 'phone', 'key'];

        foreach ($properties as $property) {
            $getProperty = 'get' . ucfirst($property);
            $setProperty = 'set' . ucfirst($property);
            $newValue = $newItem->$getProperty();
            $currentValue = $currentItem->$getProperty();

            if (!empty($newValue) && $newValue !== $currentValue) {
                $newHistory[$property] = $currentValue;
                $currentItem->$setProperty($newValue);
            }
        }

        if (empty($newHistory)) {
            throw new ItemException('New and old values are the same', 400);
        }

        $currentHistory = ($currentItem->getHistory()) ? json_decode($currentItem->getHistory(), true) : [];
        $newHistory['updated_at'] = $currentItem->getUpdated_at();
        array_push($currentHistory, $newHistory);
        $currentItem->setHistory(json_encode($currentHistory));

        try {
            $statement = $this->connection->prepare(
                'UPDATE `item` 
                SET 
                    `name` = :name, 
                    `phone` = :phone, 
                    `key` = :key,
                    `history` = :history,
                    `created_at` = :created_at, 
                    `updated_at` = :updated_at
                WHERE `id` = :id'
            );
            $statement->execute([
                ':id' => $currentItem->getId(),
                ':name' => $currentItem->getName(),
                ':phone' => $currentItem->getPhone(),
                ':key' => $currentItem->getKey(),
                ':history' => $currentItem->getHistory(),
                ':created_at' => $currentItem->getCreated_at(),
                ':updated_at' => date('Y-m-d H:i:s')
            ]);
        } catch (Exception $e) {
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage = 'update ';
        $updated['id'] = $currentItem->getId();
        return $this->get($updated);
    }


    public function delete(array $parameters)
    {
        $currentItem = $this->get($parameters);
        $currentItem->setDeleted_at(date('Y-m-d H:i:s'));

        try {
            $statement = $this->connection->prepare(
                'UPDATE `item` 
                SET 
                    `deleted_at` = :deleted_at
                WHERE `id` = :id'
            );
            $statement->execute([
                ':id' => $currentItem->getId(),
                ':deleted_at' => $currentItem->getDeleted_at()
            ]);
        } catch (Exception $e) {
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage .= ' deleted';
        return (string)NULL;
    }


    private function getItemFromRequest($parameters): Item
    {
        $item = new Item();
        $method = null;

        foreach ($parameters as $parameter => $value) {
            if (
                $parameter === 'history' ||
                $parameter === 'created_at' ||
                $parameter === 'updated_at' ||
                $parameter === 'deleted_at'
            ) {
                throw new ParametersException('Parameter ' . $parameter . ' not allowed', 400);
            }
            $method = 'set' . $parameter;
            method_exists($item, $method) ?
                $item->$method($value) :
                throw new ParametersException('Parameter ' . $parameter . ' not allowed', 400);
        }

        return $item;
    }


    private function getItemFromDB(PDOStatement $statement): Item
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($result)) {
            throw new ItemException('Item not found', 404);
        }

        $item = new Item();
        $method = null;

        foreach ($result as $key => $value) {
            $method = 'set' . $key;
            $item->$method($value);
        }

        return $item;
    }


    public function responseMessage()
    {
        return $this->responseMessage;
    }
}
