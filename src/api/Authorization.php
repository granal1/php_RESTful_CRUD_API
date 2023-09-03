<?php

namespace Granal1\RestfulPhp\api;

use Granal1\RestfulPhp\Exceptions\AuthException;

class Authorization{

    private $token;
    private $authorized;

    function __construct(){
    }

    
    public function check(string $token) :bool
    {
        $this->token = $token;
        $tokens = require dirname(__DIR__, 2) . '/config/apiTokens.php';

        $this->authorized = in_array($this->token, $tokens) ? true : false;
        
        if (!$this->authorized) {
            throw new AuthException('Unauthorized user', 401);
        }

        return $this->authorized;
    }
}
