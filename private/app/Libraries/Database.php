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
    public $users;
    public $customers;
    public $tickets;
    public $crypt;

    protected $container;
    protected $settings;
    protected $logger;
    
    protected $dbh;
    protected $stmt;
    protected $result;

    public function __construct(\Psr\Container\ContainerInterface $container, array $settings)
    {
        $this->container = $container;
        $this->settings = $settings;
        $this->crypt = new \App\Libraries\Crypto($this, CRYPT_OPTIONS);

        $this->createLogger();
        $this->connect();

        $this->users = new \App\Models\UserModel($this);
        $this->customers = new \App\Models\CustomerModel($this);
        $this->tickets = new \App\Models\TicketModel($this);
    }

    public function __destruct() {}

    public function prepareStatement(string $sql) : PDOStatement
    {
        $this->stmt = $this->dbh->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        
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

    public function executeStatement(PDOStatement $stmt)
    {
        try
        {
            $this->result = $stmt->execute();
            return $this->result;
        }
        catch (PDOException $e)
        {
            throw new PDOException($e->getMessage());
            $this->logger->error($e->getMessage());
        }
    }

    public function getHandle() : PDO
    {
        return $this->dbh;
    }

    private function createLogger() : void
    {
        $this->logger = new \Monolog\Logger('Database');
        $this->logger->pushHandler(new \Monolog\Handler\StreamHandler(LOG_PATH . '/database.log'));
    }

    private function connect() : void
    {
        $db_user = $this->settings['db_user'];
        $db_pass = $this->settings['db_pass'];

        $db_host = $this->settings['db_host'];
        $db_name = $this->settings['db_name'];
        // $db_charset = $this->settings['db_charset'];

        $dsn = 'mysql:dbname=' . $db_name . ';host=' . $db_host;

        $this->logger->info('Attempting a connection using DSN: ' . $dsn . ' with user ' . $db_user);

        try {

            $this->dbh = new PDO($dsn, $db_user, $db_pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->logger->info('Connected to database successfully.');

        } catch (PDOException $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
            $this->logger->error($e->getMessage());

        }
    }
}