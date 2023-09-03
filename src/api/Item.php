<?php

namespace Granal1\RestfulPhp\api;

class Item 
{
    public function __construct(
        private int $id, 
        private ?string $name, 
        private ?string $phone, 
        private string $key, 
        private string $created_at, 
        private string $updated_at,
        private ?string $history
    ){
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
    public function setId($id)
    {
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
    public function setName($name)
    {
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
    public function setPhone($phone)
    {
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
    public function setKey($key)
    {
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
    public function setHistory($history)
    {
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
    public function setCreated_at($created_at)
    {
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
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
