<?php
include_once 'functions/functions.php';
$theme = 'light';
if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    setcookie('theme', $theme);
} elseif (isset($_COOKIE['theme'])) {
    $theme = $_COOKIE['theme'];
}
$filter = 'all';
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    setcookie('filter', $filter);
} elseif (isset($_COOKIE['filter'])) {
    $filter = $_COOKIE['filter'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/milligram.css">
    <link rel="stylesheet" href="css/style.css">
    <title>To Do List</title>
</head>
<body class="<?php echo $theme ?>">