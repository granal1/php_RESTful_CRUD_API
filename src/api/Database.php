<?php

namespace Granal1\RestfulPhp\api; 

use PDO;
use PDOException;
use Granal1\RestfulPhp\Exceptions\DBException;


class Database
{
    public static function getConnection($configFile = null): PDO
    {
        $conn = null;
        
        $configFile === null ? 
        $configFile = dirname(__DIR__, 2) . '/config/app.ini' : 
        $configFile;
        
        if(!is_file($configFile)){
            throw new DBException('DB connection error. Settings not found', 503);
        }
        $config = parse_ini_file($configFile);

        try {
            $conn = new PDO(
                "mysql:host=" . $config['host'] . ";dbname=" . $config['db_name'], 
                $config['db_user'], 
                $config['db_password']
            );
            $conn->exec("set names utf8");
        } catch (PDOException $exception) {
            throw new DBException('DB connection error', 503);
        }

        return $conn;
    }
}