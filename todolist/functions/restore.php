<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $history = getTodos('history');
    array_splice($history, $index, 1);
    saveTodos($history, 'delete');
    $task = $_POST['task'];
    $due_date = $_POST['due_date'];
    $category = $_POST['category'];
    $completed = $_POST['completed'];
    $todos = getTodos();
    $todos[] = ['task' => $task, 'completed' => $completed, 'due_date' => $due_date, 'category' => $category];
    saveTodos($todos);
}

header('Location: ../index.php');
exit();

