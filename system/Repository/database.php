<?php
defined('BASE_URL') OR exit('Access denied !!!');

/**
 * Database class to directly connect and get data from server
 */
class database {
    var $sql, $pdo, $statement;
    private static $instance = null;

    private function __construct() {
        $dsn = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";port=" . PORT . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, USER, PASS, $options);
        } catch (PDOException $e) {
            // Log the error and throw a custom exception
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed. Please try again later.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    // Prevent cloning of the instance
    function __clone() {}

    // Prevent unserialize of the instance
    function __wakeup() {}

    function set_query($sql)
    {
        $this->sql = $sql;
        return $this;
    }

    private function exec($params = []) {
        $this->statement = $this->pdo->prepare($this->sql);
        $this->statement->execute($params);
        return $this->statement;
    }

    function load_row($params = [])
    {
        try {
            return $this->exec($params)->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
            // debug purpose
            // exit("Query execution failed: " . $e->getMessage());
        }
    }

    function load_rows($params = [])
    {
        try {
            return $this->exec($params)->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return false;
            // debug purpose
            // exit("Query execution failed: " . $e->getMessage());
        }
    }

    function save($params = [])
    {
        try {
            return $this->exec($params);
        } catch (PDOException $e) {
            return false;
            // debug purpose
            // exit("Query execution failed: " . $e->getMessage());
        }
    }

    function disconnect() {
        $this->pdo = null;
        self::$instance = null;
    }
}