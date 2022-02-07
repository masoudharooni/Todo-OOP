<?php

namespace App;

@session_start();
include "interfaces.php";

abstract class Model extends Connection implements createable, updateable
{
    protected $table;
    public function __construct()
    {
        $this->connect();
    }
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]) ?? false;
    }
}
