<?php
include_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $todos = getTodos();
    $todos[$index]['completed'] = !$todos[$index]['completed'];
    // si je ne force pas le 0, c'est vide dans le fichier csv quand la valeur est false
    if($todos[$index]['completed'] == FALSE){
        $todos[$index]['completed'] = 0;
    }
    saveTodos($todos);
}

header('Location: ../index.php');
exit();
?>
