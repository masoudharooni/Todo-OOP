<?php

namespace App;

class Folder extends Model
{
    protected $table = "folders";
    // !* create method----arguments = user_id and title in an array *!
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (user_id , title) VALUES (:user_id,:title)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([":user_id" => $this->user_id, ":title" => $data['title']]) ?? false;
    }

    // !* update method----arguments = title and folder id in an array *!
    public function update(array $data): bool
    {
        $sql = "UPDATE {$this->table} SET title = :title WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $data['title'], ':id' => $data['id']]) ?? false;
    }

    // !* display method----arguments = null or folder_id*!
    public function display(int $folder_id = null, int $id = null)
    {
        $query_condition = null;
        if (!is_null($folder_id)) {
            $query_condition = " AND folder_id = :folder_id";
        }
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id {$query_condition}";
        $stmt = $this->conn->prepare($sql);
        if (!is_null($query_condition)) {
            $stmt->execute([':folder_id' => $folder_id, ':user_id' => $this->user_id]);
        } else {
            $stmt->execute([':user_id' => $this->user_id]);
        }
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
