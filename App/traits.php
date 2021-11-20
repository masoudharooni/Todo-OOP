<?php

namespace App;



trait toggleStatus
{
    public function toggleStatus(int $id): bool
    {
        $sql = "UPDATE {$this->table} SET status = 1 - status WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]) ?? false;
    }
}

trait validation
{
    private function isThereEmail(string $email): bool
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return is_object($stmt->fetch(\PDO::FETCH_OBJ)) ?? false;
    }

    private function isSafePass($password): bool
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            return false;
        }
        return true;
    }
}
