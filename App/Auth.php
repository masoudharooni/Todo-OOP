<?php

namespace App;


include "interfaces.php";
include 'traits.php';
include "Connection.php";
session_start();

class Auth extends Connection implements authable
{
    private $table = "users";
    use validation;

    public function __construct()
    {
        $this->connect();
    }

    // * sign UP method --- arguments => password and email in $data array
    public function signUp(array $data)
    {
        if (!$this->isThereEmail($data['email'])) {
            if ($this->isSafePass($data['password'])) {
                $sql = "INSERT INTO {$this->table} (email , password ) VALUES (:email , :password)";
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute([':email' => $data['email'], ':password' => password_hash($data['password'], PASSWORD_BCRYPT)])) {
                    return [
                        'bool' => true,
                        'message' => "You have registered!"
                    ];
                }
            } else {
                return [
                    'bool' => false,
                    'message' => 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.'
                ];
            }
        } else {
            return [
                'bool' => false,
                'message' => "This Email Already Used!"
            ];
        }
    }

    private function getUserByEmail(string $email)
    {
        if (!$this->isThereEmail($email)) {
            return false;
        }
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function login(array $data): bool
    {
        $userInformation = $this->getUserByEmail($data['email']);
        if (is_object($userInformation)) {
            if (password_verify($data['password'], $userInformation->password)) {
                $_SESSION['login'] = $userInformation;
                return true;
            }
        }
        return false;
    }
}
