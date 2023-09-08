<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\ValidationException;

class Item 
{
    private ?int $id = null;
    private ?string $name = null; 
    private ?string $phone = null; 
    private string $key = '';
    private ?string $history = null;
    private ?string $created_at = null; 
    private ?string $updated_at = null;
    private ?string $deleted_at = null;
    private array $rules = [];

    public function __construct()
    {
        $this->rules = require dirname(__DIR__, 2) . '/config/itemRules.php';
    }

    
    public function __toString()
    {
        $historyArray = (!empty($this->history)) ? json_decode($this->history, true) : null;
        return json_encode([
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'key' => $this->key,
            'history' => $historyArray,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        if (!empty($id) && !preg_match($this->rules['id'], $id)) {
            throw new ValidationException('id = ' . $id . ' - uncorrect; ', 400);
        }        
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        if (!empty($name) && !preg_match($this->rules['name'], $name)) {
            throw new ValidationException('name = ' . $name . ' - uncorrect; ', 400);
        } 
        $this->name = $name;

        return $this;
    }


    /**
     * Get the value of phone
     */ 
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Set the value of phone
     *
     * @return  self
     */ 
    public function setPhone(?string $phone)
    {
        if (!empty($phone) && !preg_match($this->rules['phone'], $phone)) {
            throw new ValidationException('phone = ' . $phone . ' - uncorrect; ', 400);
        } 
        $this->phone = $phone;

        return $this;
    }


    /**
     * Get the value of key
     */ 
    public function getKey()
    {
        return $this->key;
    }


    /**
     * Set the value of key
     *
     * @return  self
     */ 
    public function setKey(string $key)
    {
        //не должен быть пустым
        if (!preg_match($this->rules['key'], $key)) {
            throw new ValidationException('key = ' . $key . ' - uncorrect; ', 400);
        } 
        $this->key = $key;

        return $this;
    }


    /**
     * Get the value of history
     */ 
    public function getHistory()
    {
        return $this->history;
    }


    /**
     * Set the value of history
     *
     * @return  self
     */ 
    public function setHistory(?string $history)
    {
        if (!empty($history) && !preg_match($this->rules['history'], $history)) {
            throw new ValidationException('history = ' . $history . ' - uncorrect; ', 400);
        } 
        $this->history = $history;

        return $this;
    }


    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }


    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at(string $created_at)
    {
        if (!empty($created_at) && !preg_match($this->rules['created_at'], $created_at)) {
            throw new ValidationException('created_at = ' . $created_at . ' - uncorrect; ', 400);
        } 
        $this->created_at = $created_at;

        return $this;
    }


    /**
     * Get the value of updated_at
     */ 
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    
    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdated_at(string $updated_at)
    {
        if (!empty($updated_at) && !preg_match($this->rules['updated_at'], $updated_at)) {
            throw new ValidationException('updated_at = ' . $updated_at . ' - uncorrect; ', 400);
        } 
        $this->updated_at = $updated_at;

        return $this;
    }


    /**
     * Get the value of deleted_at
     */ 
    public function getDeleted_at()
    {
        return $this->deleted_at;
    }


    /**
     * Set the value of deleted_at
     *
     * @return  self
     */ 
    public function setDeleted_at(?string $deleted_at)
    {
        if (!empty($deleted_at) && !preg_match($this->rules['deleted_at'], $deleted_at)) {
            throw new ValidationException('deleted_at = ' . $deleted_at . ' - uncorrect; ', 400);
        } 
        $this->deleted_at = $deleted_at;

        return $this;
    }
}
