<?php
session_start();
include_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    if (empty($username)) {
        $_SESSION['error'] = 'Username cannot be empty or only spaces.';
        header('Location: ../index.php');
        exit();
    }
    $users = getUsers();
    if (!in_array($username, $users)) {
        saveUser($username);
    }

    $_SESSION['logged'] = true;
    $_SESSION['username'] = $username;
    header('Location: ../index.php');
    exit();
}
