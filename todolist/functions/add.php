<?php
session_start();
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST['task'];
    $due_date = $_POST['due_date'];
    $category = $_POST['category'];
    $username = $_SESSION['username'];
    $todos = getTodos();
    $todos[] = ['task' => $task, 'completed' => 0, 'due_date' => $due_date, 'category' => $category, 'username' => $username];
    saveTodos($todos);
}

header('Location: ../index.php');
exit();

