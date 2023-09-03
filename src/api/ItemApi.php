<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\ItemException;
use PDO;
use PDOStatement;
use Exception;
use Granal1\RestfulPhp\Exceptions\DBException;

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
        $validatedGet = (new Validation())->check($parameters, 'itemGetRules');

        // По секретному ключу '0900070000' можно получить всесь список item
    //     if ($parameters['id'] === '0900070000') {

    //         try {
    //             $statement = $this->connection->prepare("SELECT * FROM `item` ORDER BY `id`");
    //             $statement->execute();
    //         }catch(Exception $e){
    //             throw new DBException($e->getMessage(), 503);
    //             return;
    //         }

    //         $this->responseMessage .= 'list successful';
    //         return $this->getItemList($statement);
    //     }
    //     else{

            try {
                $statement = $this->connection->prepare(
                    'SELECT * FROM item WHERE id = :id'
                );
                $statement->execute([
                    ':id' => (string)$parameters['id'],
                ]);
            }catch(Exception $e){
                throw new DBException($e->getMessage(), 503);
                return;
            }

            $this->responseMessage .= 'successful';
            return $this->getItem($statement);
    //     }
    }


    public function post(array $parameters)
    {
        $validatedPost = (new Validation())->check($parameters, 'itemPostRules');

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
                ':name' => $parameters['name'],
                ':phone' => $parameters['phone'],
                ':key' => $parameters['key'],
                ':created_at' => date('Y-m-d H:i:s'),
                ':updated_at' => date('Y-m-d H:i:s')
            ]);
        }catch(Exception $e){
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage .= 'post ';
        $created['id'] = $this->connection->lastInsertId();
        return $this->get($created);
    }


    public function delete(array $parameters)
    {
        $validatedDelete = (new Validation())->check($parameters, 'itemDeleteRules');
        if ($this->findId($parameters)) {
            try {
                $statement = $this->connection->prepare(
                    'DELETE FROM item WHERE id = :id'
                );
                $statement->execute([
                    ':id' => (int)$parameters['id']
                ]);
            }catch(Exception $e){
                throw new DBException($e->getMessage(), 503);
                return;
            }
        }
        else {
            throw new ItemException('Item not found', 404);
        }

        if (!$this->findId($parameters)) {
            $this->responseMessage .= 'deleted successful';
            return (string)NULL;
        }
        else {
            throw new ItemException('Conflict (delete failed)', 409);
        }
    }


    public function update(array $parameters)
    {
        $validatedUpdate = (new Validation())->check($parameters, 'itemUpdateRules');
        $current = json_decode($this->get($parameters), true); 

        ($current['history']) ?: $current['history'] = [];

        $newHistory = array(
            'name' => $current['name'], 
            'phone' => $current['phone'], 
            'key' => $current['key'], 
            'updated_at' => $current['updated_at']
        );

        array_push($current['history'], $newHistory);
        $current['history'] = json_encode($current['history']);

        foreach ($current as $key => $value) {
            $newData[$key] = (!array_key_exists($key, $parameters) || $parameters[$key] === $value) ? $value : $parameters[$key];
        }

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
                ':id' => $newData['id'],
                ':name' => $newData['name'],
                ':phone' => $newData['phone'],
                ':key' => $newData['key'],
                ':history' => $newData['history'],
                ':created_at' => $newData['created_at'],
                ':updated_at' => date('Y-m-d H:i:s')
            ]);
        }catch(Exception $e){
            throw new DBException($e->getMessage(), 503);
            return;
        }

        $this->responseMessage = 'update ';
        return $this->get($newData);
    }


    private function findId(array $parameters): ?string
    {
        $validatedGet = (new Validation())->check($parameters, 'itemGetRules');

        try {
        $statement = $this->connection->prepare(
            'SELECT id FROM item WHERE id = :id'
        );
        $statement->execute([
            ':id' => (string)$parameters['id'],
        ]);
        }catch(Exception $e){
            throw new DBException($e->getMessage(), 503);
            return null;
        }

        $exist =  $statement->fetch(PDO::FETCH_ASSOC);
        return $exist['id'] ?? null;
    }


    public function responseMessage()
    {
        return $this->responseMessage;
    }

    
    private function getItem(PDOStatement $statement): string
    {
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($result)){
            throw new ItemException('Item not found', 404);
        }

        $item = new Item(
        $result['id'],
        $result['name'], 
        $result['phone'],
        $result['key'],
        $result['created_at'],
        $result['updated_at'],
        $result['history']
        );

        return (string)$item;
    }


    private function getItemList(PDOStatement $statement): string
    {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)){
            throw new ItemException('Item not found', 404);
        }
        
        foreach ($result as $row) {
            $item = new Item(
                $row['id'],
                $row['name'], 
                $row['phone'],
                $row['key'],
                $row['created_at'],
                $row['updated_at'],
                $row['history']
            );
            $items[] = json_decode((string)$item);
        }

        return json_encode($items);
    }
}