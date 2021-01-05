<?php


class Database
{
    private $host = 'localhost'; //Host name
    private $db_name = 'assessment'; //Database Name
    private $db_username = 'root'; //Database Username
    private $db_password = 'root'; //Database Password
    private $connection;
    private static $instance;

    /**
     * Database constructor.
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->db_name};", $this->db_username, $this->db_password);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Return database connection instance
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (!self::$instance) { // If no instance then make one
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Select rows in database
     * @param string $statement
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function select($statement = "", $parameters = [])
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Select row in database
     * @param string $statement
     * @param array $parameters
     * @return mixed
     * @throws Exception
     */
    public function selectRow($statement = "", $parameters = [])
    {
        try {
            $stmt = $this->executeStatement($statement, $parameters);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Execute statement
     * @param string $statement
     * @param array $parameters
     * @return false|PDOStatement
     * @throws Exception
     */
    function executeStatement($statement = "", $parameters = [])
    {
        try {
            $stmt = $this->connection->prepare($statement);
            $stmt->execute($parameters);
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}