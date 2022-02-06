<?php

namespace Services;

use App\Task;

class Tasks
{
    private $object;
    public function __construct()
    {
        $this->object = new Task;
    }
    public function get(int $user_id, int $folder_id = null, int $id = null, $char = null)
    {
        return $this->object->display($user_id, $folder_id, $id, $char);
    }
    public function add(array $data): int
    {
        return $this->object->create($data);
    }
    public function update(array $data): bool
    {
        return $this->object->update($data);
    }
    public function delete(int $taskId): bool
    {
        return $this->object->delete($taskId);
    }
}
