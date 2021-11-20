<?php
// session_start();
include "autoload.php";

session_start();

use App\Task;
use App\Folder;



if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        unset($_SESSION['login']);
    }
}

if (!isset($_SESSION['login'])) {
    header("Location:auth.php");
}

$allTask = new Task;
if (isset($_GET['folder']) and is_numeric($_GET['folder'])) {
    $allTask = $allTask->display($_GET['folder'], null);
} else {
    $allTask = $allTask->display();
}



$allFolder = new Folder;
$allFolder = $allFolder->display();
include 'views/tpl-index.php';
