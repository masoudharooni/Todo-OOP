<?php

namespace App;

interface deleteable
{
    public function delete();
}

interface createable
{
    public function create(array $data): int;
}

interface updateable
{
    public function update(array $data): bool;
}

interface displayable
{
    public function display(int $folder_id = null, int $id = null);
}

interface authable
{
    public function login(array $data);
    public function signUp(array $data);
}
