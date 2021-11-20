<?php

namespace App;


class Connection
{
    protected $conn;
    private array $dbConfig = [
        'dbms'      => 'mysql',
        'host'      => 'localhost',
        'dbname'    => 'todo_obj',
        'username'  => 'root',
        'password'  => ""
    ];

    public function connect()
    {
        try {
            $this->conn = new \PDO("{$this->dbConfig['dbms']}:host={$this->dbConfig['host']};
            dbname={$this->dbConfig['dbname']}", $this->dbConfig['username'], $this->dbConfig['password']);
        } catch (\PDOException $e) {
            die("Connetion to dataBase is not true , ERROR : {$e->getMessage()}");
        }
    }
}
