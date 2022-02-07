<?php

namespace Services;

use App\Folder;

class Folders
{
    private $object;
    public function __construct()
    {
        $this->object = new Folder;
    }
    public function get(int $user_id, int $folder_id = null)
    {
        return $this->object->display($user_id, $folder_id);
    }
    public function add(array $parameters): bool
    {
        return $this->object->create($parameters);
    }
    public function update(array $parameters): bool
    {
        return $this->object->update($parameters);
    }
    public function delete(int $id): bool
    {
        return $this->object->delete($id);
    }
}
