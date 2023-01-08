<?php

/**
 * 
 */

declare (strict_types = 1);

namespace App\Libraries;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    protected $container;
    protected $settings;
    
    protected $dbh;
    protected $stmt;
    protected $result;

    public function __construct(\Psr\Container\ContainerInterface $container, array $settings)
    {
        $this->container = $container;
        $this->settings = $settings;

        $this->connect();
    }

    public function __destruct() {}

    public function prepareStatement(string $sql) : PDOStatement
    {
        $this->stmt = $this->dbh->prepare($sql);
        
        return $this->stmt;
    }

    public function fetchSingleRow(PDOStatement $stmt) : array
    {
        $this->stmt = $stmt;
        $this->result = Null;

        try {
           $this->result = $this->stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }

        return $this->result;
    }

    public function fetchAllRows(PDOStatement $stmt) : array
    {
        $this->stmt = $stmt;
        $this->result = Null;

        try {
           $this->result = $this->stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }

        return $this->result;
    }

    private function connect() : void
    {
        $db_user = $this->settings['user'];
        $db_pass = $this->settings['pass'];

        $db_host = $this->settings['db_host'];
        $db_name = $this->settings['db_name'];
        // $db_charset = $this->settings['db_charset'];

        $dsn = 'mysql:dbname=' . $db_name . ';host=' . $db_host;

        try {
            $this->dbh = new PDO($dsn, $db_user, $db_pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}