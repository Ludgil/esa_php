<?php
session_start();
include_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $users = getUsers();
    if (!in_array($username, $users)) {
        saveUser($username);
    }

    $_SESSION['logged'] = true;
    $_SESSION['username'] = $username;
    header('Location: ../index.php');
    exit();
}
