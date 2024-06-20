<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $todos = getTodos();
    $history = getTodos('history');
    $todoDeleted = $todos[$index];
    $history[] = $todoDeleted;
    array_splice($todos, $index, 1);
    saveTodos($history, 'history');
    saveTodos($todos);
}

header('Location: ../index.php');
exit();

