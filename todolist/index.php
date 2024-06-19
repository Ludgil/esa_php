<?php
include_once 'config.php';
include_once 'pages/layout/header.php';

if (isset($_GET['page']) && $_GET['page'] == 'edit' && isset($_POST['index'])) {
    include_once 'pages/edit.php';
}elseif(isset($_GET['page']) && $_GET['page'] == 'add_category'){
    include_once 'pages/add_category.php';
}elseif(isset($_GET['page']) && $_GET['page'] == 'history'){
    include_once 'pages/history.php';
}else {
    $todos = getTodos();
    $categories = getCategories();
    if ($filter != "all"){
        $todos = array_filter($todos, function($todo) use ($filter) {
            return $todo["category"] === $filter;
        });
    }
    include_once 'pages/body.php';
}

include_once 'pages/layout/footer.php';
