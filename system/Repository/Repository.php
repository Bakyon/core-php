<?php
abstract class Repository {
    protected $connection;

    function __construct() {
        $this->connection = database::getInstance();
    }

    function disconnect() {
        $this->connection = null;
    }
}