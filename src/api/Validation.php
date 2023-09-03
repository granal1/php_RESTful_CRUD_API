<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\ValidationException;

class Validation
{
    private $rules;
    private $data;

    function __construct() {
    }

    
    public function check(array $data, string $ruleName): bool
    {
        $this->rules = require dirname(__DIR__, 2) . '/config/' . $ruleName . '.php';
        $this->data = $data;
        $unvalidated = '';

        foreach ($this->rules['required'] as $key) {
            if (!array_key_exists($key, $this->data)) {
                $unvalidated .= $key . ' - required; ';
            }
        }

        foreach ($this->data as $key => $value) {
            if (!preg_match_all($this->rules['pattern'][$key], $value)) {
                $unvalidated .= $key . '=' . $value . ' - uncorrect; ';
            }
        }

        if (!empty($unvalidated)) {
            throw new ValidationException($unvalidated, 400);
        }

        return true;
    }
}
