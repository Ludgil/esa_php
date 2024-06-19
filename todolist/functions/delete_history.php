<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $history = getTodos('history');
    array_splice($history, $index, 1);
    saveTodos($history, 'delete');
}

header('Location: ../index.php');
exit();

