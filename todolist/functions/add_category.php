<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $categories = getCategories();
    $categories[] = $category;
    saveCategories($categories);
}

header('Location: ../index.php');
exit();