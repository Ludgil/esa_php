<?php
include_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['index']) && isset($_POST['task'])) {
    $index = $_POST['index'];
    $task = $_POST['task'];
    $due_date = $_POST['due_date'];
    $category = $_POST['category'];
    $todos = getTodos();
    $todos[$index]['task'] = $task;
    $todos[$index]['due_date'] = $due_date;
    $todos[$index]['category'] = $category;
    saveTodos($todos);
    header('Location: ../index.php');
    exit();
}