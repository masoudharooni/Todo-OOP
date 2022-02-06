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
    public function search(int $user_id, string $character)
    {
        return $this->object->search($user_id, $character);
    }
}
