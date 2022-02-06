<?php

namespace App;


include "traits.php";
class Task extends Model
{
    protected $table = 'tasks';
    use toggleStatus;

    // !* create method----arguments = folder_id and title in an array *!
    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (folder_id , title , user_id) VALUES (:folder_id,:title , :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":folder_id" => $data['folder_id'], ":title" => $data['title'], ":user_id" => $data['user_id']]);
        return $this->conn->lastInsertId();
    }

    // !* update method----arguments = title and task id in an array *!
    public function update(array $data): bool
    {
        $sql = "UPDATE {$this->table} SET title = :title WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':title' => $data['title'], ':id' => $data['id']]) ?? false;
    }

    // !* display method----arguments = null or folder_id*!
    public function display(int $user_id, int $folder_id = null, int $id = null, $char = null)
    {
        $folder_query_condition = null;
        $task_query_condition = null;
        $search_in_tasks_query_condition = null;
        if (!is_null($char))
            $search_in_tasks_query_condition = "AND title LIKE '$char%'";
        if (!is_null($folder_id)) {
            $folder_query_condition = "AND folder_id = :folder_id";
        } elseif (!is_null($id)) {
            $task_query_condition = "AND id = :id";
        }

        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id {$folder_query_condition} {$task_query_condition} {$search_in_tasks_query_condition}";
        $stmt = $this->conn->prepare($sql);
        if (!is_null($folder_query_condition)) {
            $stmt->execute([":folder_id" => $folder_id, ":user_id" => $user_id]);
        } elseif (!is_null($task_query_condition)) {
            $stmt->execute([":id" => $id, ":user_id" => $user_id]);
        } else {
            $stmt->execute([':user_id' => $user_id]);
        }
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function search(int $user_id, string $char)
    {
        $sql = "SELECT * FROM {$this->table} WHERE title LIKE '%$char%' AND user_id = $user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ) ?? null;
    }
}
