<?php

namespace App;

@session_start();
include "Connection.php";
include "interfaces.php";

abstract class Model extends Connection implements createable, updateable, displayable
{
    protected $table;
    protected $user_id;
    public function __construct()
    {
        $this->user_id = $_SESSION['login']->id;
        // Connection to DataBase
        $this->connect();
    }
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]) ?? false;
    }
}
