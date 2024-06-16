<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    echo CSV_PATH;
    $todos = getTodos();
    array_splice($todos, $index, 1);
    saveTodos($todos);
}

header('Location: ../index.php');
exit();

