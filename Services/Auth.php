<?php

namespace Services;

class Auth
{
    private $object;
    public function __construct()
    {
        $this->object = new \App\Auth;
    }
    public function signup(array $data): array
    {
        return $this->object->signUp($data);
    }
    public function login(array $data): bool
    {
        return 1;
    }
}
