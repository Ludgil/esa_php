<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $history = getTodos('history');
    array_splice($history, $index, 1);
    saveTodos($history, 'history');
}

header('Location: ../index.php');
exit();

