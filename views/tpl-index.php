<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Task manager UI</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- bootstrap cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="page">
        <div class="pageHeader">
            <div class="title">Dashboard</div>
            <div class="userPanel">
                <a href="?logout=1" style="color: inherit;text-decoration: none;">
                    <i class="fas fa-sign-out-alt clickable"></i>
                </a>
                <span class="username"><?= $_SESSION['login']->email ?></span>
            </div>
        </div>
        <div class="main">
            <div class="nav">
                <div class="searchbox">
                    <div><i class="fa fa-search"></i>
                        <input type="search" placeholder="Search" id="searchInput" style="outline: none;">
                        <div class="search-result" id="search-result">

                        </div>
                    </div>
                </div>
                <div class="menu">
                    <div class="title">Navigation</div>
                    <ul class="all_folder">
                        <a href="<?= $_SERVER['PHP_SELF'] ?>" style="color: inherit; text-decoration: none;">
                            <li class="active"> <i class="fa fa-tasks"></i>All Tasks</li>
                        </a>
                        <?php foreach ($allFolder as $folder) : ?>
                            <li class="folder">
                                <i data-id="<?= $folder->id ?>" class="fas fa-folder editFolderIcon" style="color: #007bec;"></i>
                                <a style="color: inherit;text-decoration: none;" href="?folder=<?= $folder->id ?>">
                                    <span class="folder_title"><?= $folder->title ?></span>
                                </a>
                                <i data-id="<?= $folder->id ?>" style="float: right;" class="deleteIcon deleteIconFolder fas fa-backspace clickable"></i>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="add-folder-box">
                        <input type="text" class="form-control" id="addFolderInput" aria-describedby="helpId" placeholder="Folder Name . . .">
                        <label for="">
                            <i class="fas fa-times clickable closeFolderInputBtn" style="color: red;float: left;position: relative; top: 29px; right: 10px;font-size: 20px;display: none;"></i>
                            <input style="margin-top: 15px;display: none;" type="text" class="form-control" id="editFolderInput" aria-describedby="helpId" placeholder="New Folder Name . . .">
                        </label>
                    </div>
                </div>
            </div>
            <div class="view">
                <div class="viewHeader">
                    <div class="title">Manage Tasks</div>
                    <div class="functions">
                        <div class="button active">
                            <?php if (isset($_GET['folder']) and is_numeric($_GET['folder'])) : ?>
                                <input id="addTaskInput" data-folder-id="<?= $_GET['folder'] ?>" type="text" placeholder="add new task . . ." autofocus>
                            <?php endif; ?>
                        </div>
                        <div class="button">Completed</div>
                        <div class="button inverz"><i class="fa fa-trash-o"></i></div>
                    </div>
                </div>
                <div class="content">
                    <div class="list">
                        <div class="title">Today</div>
                        <ul class="taskList">
                            <?php foreach ($allTask as $task) : ?>
                                <li class="task">
                                    <i data-id="<?= $task->id ?>" class="fas <?= ($task->status) ? "fa-check-square" : "fa-square" ?> squareIcon clickable"></i>
                                    <span class="taskTitle"><?= $task->title ?></span>
                                    <div class="info">
                                        <span class="created_at">Created at : <?= $task->created_at ?></span>
                                        <span>
                                            <i data-id="<?= $task->id ?>" class="fas fa-backspace deleteIcon clickable deleteTaskIcon"></i>
                                            <i data-id="<?= $task->id ?>" class="fas fa-edit editIcon clickable"></i>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <label for="">
                        <i class="fas fa-times clickable closeEditInputBtn" style="color: red;position: relative;left: 22px;display: none;"></i>
                        <input type="text" class="editTaskInput" id="editTaskInput" placeholder="Enter New Name For This Task . . . ">
                    </label>
                </div>
            </div>
        </div>
    </div>


    <!-- Jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            var input = document.getElementById("addTaskInput");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode == 13) {
                    if (input.value.length > 3) {
                        $.ajax({
                            type: "post",
                            url: "process/ajaxHandler.php",
                            data: {
                                action: 'addTask',
                                title: input.value,
                                folder_id: input.getAttribute('data-folder-id')
                            },
                            success: function(response) {
                                if (response == true) {
                                    location.reload();
                                } else {
                                    alert(response);
                                }
                            }
                        });
                    } else {
                        alert("Task Title must gerether than 3");
                    }
                }
            });

        });


        $(document).ready(function() {
            var task_id;
            var editInput;
            var editTaskBtn;
            $('.editIcon').click(function(e) {
                editTaskBtn = e;
                task_id = e.target.getAttribute('data-id');
                var oldTaskTitle = e.target.closest('.task').querySelector('.taskTitle').innerHTML;
                $('.editTaskInput').val(oldTaskTitle);
                editInput = document.getElementById('editTaskInput');
                $('.editTaskInput').fadeIn(600);
                $('.closeEditInputBtn').fadeIn(600);
                editInput.focus();

            });

            document.getElementById('editTaskInput').addEventListener('keyup', function(param) {
                if (param.keyCode == 13) {
                    if (editInput.value.length > 3) {
                        $.ajax({
                            type: "post",
                            url: "process/ajaxHandler.php",
                            data: {
                                action: 'updateTask',
                                title: editInput.value,
                                id: task_id
                            },
                            success: function(response) {
                                if (response == true) {
                                    editTaskBtn.target.closest('.task').querySelector('.taskTitle').innerHTML = editInput.value;
                                    $('.editTaskInput').fadeOut(600);
                                    $('.closeEditInputBtn').fadeOut(600);
                                } else {
                                    alert(response);
                                }
                            }
                        });

                    } else {
                        alert("Task Title must gerether than 3");
                    }
                }
            });

            // add folder ajax 
            var addFolderInput = document.getElementById('addFolderInput');
            addFolderInput.addEventListener('keyup', function(event) {
                if (event.keyCode == 13) {
                    if (addFolderInput.value.length > 0 && addFolderInput.value.length < 8) {
                        $.ajax({
                            type: "post",
                            url: "process/ajaxHandler.php",
                            data: {
                                action: 'addFolder',
                                title: addFolderInput.value
                            },
                            success: function(response) {
                                if (response == true) {
                                    location.reload();
                                } else {
                                    alert(response);
                                }
                            }
                        });
                    } else {
                        alert("your folder name too big!");
                    }
                }
            });




            $('.closeEditInputBtn').click(function(e) {
                e.preventDefault();
                $('.editTaskInput').fadeOut(600);
                $(this).fadeOut(600);
            });


            // edit folder name 
            var folder_id;
            var editFolderInput;
            var editFolderBtn;
            $('.editFolderIcon').click(function(e) {
                editFolderBtn = e;
                folder_id = e.target.getAttribute('data-id');
                var oldFolderTitle = e.target.closest('.folder').querySelector('.folder_title').innerHTML;
                $('#editFolderInput').val(oldFolderTitle);
                editFolderInput = document.getElementById('editFolderInput');
                $('#editFolderInput').fadeIn(600);
                $('.closeFolderInputBtn').fadeIn(600);
                editFolderInput.focus();

            });

            document.getElementById('editFolderInput').addEventListener('keyup', function(param) {
                if (param.keyCode == 13) {
                    if (editFolderInput.value.length > 0 && editFolderInput.value.length < 8) {
                        $.ajax({
                            type: "post",
                            url: "process/ajaxHandler.php",
                            data: {
                                action: 'updateFolder',
                                title: editFolderInput.value,
                                id: folder_id
                            },
                            success: function(response) {
                                if (response == true) {
                                    editFolderBtn.target.closest('.folder').querySelector('.folder_title').innerHTML = editFolderInput.value;
                                    $('#editFolderInput').fadeOut(600);
                                    $('.closeFolderInputBtn').fadeOut(600);
                                } else {
                                    alert(response);
                                }
                            }
                        });

                    } else {
                        alert("Folder Name is Too Big!");
                    }
                }
            });

            $('.closeFolderInputBtn').click(function(e) {
                e.preventDefault();
                $(this).fadeOut(600);
                $("#editFolderInput").fadeOut(600);
            });

        });


        $(document).ready(function() {
            $('.squareIcon').click(function(e) {
                // alert('ok');
                var task_id = $(this).attr('data-id');
                $.ajax({
                    type: "post",
                    url: "process/ajaxHandler.php",
                    data: {
                        action: "toggleStatusTask",
                        id: task_id
                    },
                    success: function(response) {
                        if (response == true) {
                            if (e.target.classList.contains('fa-check-square')) {
                                e.target.classList.remove('fa-check-square');
                                e.target.classList.add('fa-square');
                            } else {
                                e.target.classList.remove('fa-square');
                                e.target.classList.add('fa-check-square');
                            }
                        } else {
                            alert(response);
                        }
                    }
                });
            });
        });

        $(document).ready(function() {
            // delete folder 
            $('.deleteIconFolder').click(function(e) {
                var folder_id = e.target.getAttribute('data-id');
                $.ajax({
                    type: "post",
                    url: "process/ajaxHandler.php",
                    data: {
                        action: 'deleteFolder',
                        id: folder_id
                    },
                    success: function(response) {
                        if (response == true) {
                            e.target.closest('.folder').remove();
                        } else {
                            alert(response);
                        }
                    }
                });
            });
        });

        // delete task 
        $(document).ready(function() {
            $('.deleteTaskIcon').click(function(e) {
                e.preventDefault();
                var task_id = $(this).attr('data-id');
                $.ajax({
                    type: "post",
                    url: "process/ajaxHandler.php",
                    data: {
                        action: "deleteTask",
                        id: task_id
                    },
                    success: function(response) {
                        if (response == true) {
                            e.target.closest(".task").remove();
                        } else {
                            alert(response);
                        }
                    }
                });
            });
        });

        // search task
        $(document).ready(function() {
            $('#searchInput').keyup(function(e) {
                var searchInput = $('#searchInput').val();
                if (searchInput.length > 0 && searchInput != '') {
                    $.ajax({
                        type: "post",
                        url: "process/ajaxHandler.php",
                        data: {
                            action: "searchTask",
                            char: searchInput
                        },
                        success: function(response) {
                            $('#search-result').html(response);

                        }
                    });
                }
            });
        });
    </script>


</body>

</html>