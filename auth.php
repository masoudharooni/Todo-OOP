<?php
include "App/Auth.php";

use App\Auth;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        $signUp = new Auth;
        $signUp = $signUp->signUp(['password' => $_POST['password'], 'email' => $_POST['email']]);
        echo "<div class='alert alert-warning' role='alert'>{$signUp['message']}</div>";
    }


    if (isset($_POST['login'])) {
        $login = new Auth;
        $login = $login->login(['password' => $_POST['password'], 'email' => $_POST['email']]);
        if ($login) {
            echo "<div class='alert alert-warning' role='alert'>You are loggined!</div>";
            header("location:index.php");
        } else {
            echo "<div class='alert alert-warning' role='alert'>Email or password not true!</div>";
        }
        // var_dump($_POST);
    }
}





include "views/tpl-auth.php";
