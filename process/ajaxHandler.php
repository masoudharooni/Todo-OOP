<?php

use App\Folder;
use App\Task;

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die("acsess denied --- Request is not AJAX!");
}
// Request is ajax in here
include "../autoload.php";
if ($_POST['action'] == "addTask") {
    $taskObj = new Task;
    $addedTaskId = $taskObj->create(['folder_id' => $_POST['folder_id'], 'title' => $_POST['title']]);
    echo (is_numeric($addedTaskId) ?? false);
}

// delete task
if ($_POST['action'] == "deleteTask") {
    $taskObj = new Task;
    echo $taskObj->delete($_POST['id']);
}

// toggle status task
if ($_POST['action'] == "toggleStatusTask") {
    $taskObj = new Task;
    echo $taskObj->toggleStatus($_POST['id']);
}

// update task
if ($_POST['action'] == "updateTask") {
    $taskObj = new Task;
    echo $taskObj->update(['title' => $_POST['title'], 'id' => $_POST['id']]);
}

// add task
if ($_POST['action'] == "addFolder") {
    $folderObj = new Folder;
    $addedFolderId = $folderObj->create(['title' => $_POST['title']]);
    echo (is_numeric($addedFolderId) ?? false);
}

// delete folder
if ($_POST['action'] == "deleteFolder") {
    $folderObj = new Folder;
    echo $folderObj->delete($_POST['id']);
}

// update folder
if ($_POST['action'] == "updateFolder") {
    $folderObj = new Folder;
    echo $folderObj->update(['title' => $_POST['title'], 'id' => $_POST['id']]);
}

// search task 
if ($_POST['action'] == "searchTask") {
    $taskObj = new Task;
    $listOfTask = $taskObj->search($_POST['char']);
    if (!is_null($listOfTask)) {
        foreach ($listOfTask as $task) {
            echo "<a href='?folder={$task->folder_id}'><div class='result'>{$task->title}</div></a>";
        }
    } else {
        echo "<div class='not-exists'>Not Exists!</div>";
    }
}
