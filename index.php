<?php
// session_start();
include "autoload.php";

session_start();

use App\Task;
use App\Folder;
use Utility\Helper;

if (isset($_GET['logout'])) {
    if ($_GET['logout'] == true) {
        unset($_SESSION['login']);
    }
}

if (!isset($_SESSION['login'])) {
    header("Location:auth.php");
}
$currenctUserId = $_SESSION['login']->id;


$allTask = new Task;
if (isset($_GET['folder']) and is_numeric($_GET['folder'])) {
    $allTask = $allTask->display($currenctUserId, $_GET['folder']);
} else {
    $allTask = $allTask->display($currenctUserId);
}



$allFolder = new Folder;
$allFolder = $allFolder->display(Helper::getCurrentUserId());
include 'views/tpl-index.php';
