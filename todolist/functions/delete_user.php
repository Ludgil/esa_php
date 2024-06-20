<?php
include_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = $_POST['index'];
    // récupérer les users
    $users = getUsers();
    // récupérer l'utilisateur à supprimer
    $deletedUser = $users[$index];
    // l'enlever du tableau
    array_splice($users, $index, 1);
    // sauvegarder la liste sans l'utilisateur
    saveUsers($users);

    // Supprimer les tâches liées à cet utilisateur
    $todos = getTodos();
    $todos = array_filter($todos, function($todo) use ($deletedUser) {
        return $todo['username'] !== $deletedUser;
    });
    saveTodos($todos);
     // Supprimer les tâches liées dans l'historique
     $histories = getTodos('history');
     $histories = array_filter($histories, function($history) use ($deletedUser) {
         return $history['username'] !== $deletedUser;
     });
     saveTodos($histories, 'history');

    header('Location: ../index.php');
    exit();
}