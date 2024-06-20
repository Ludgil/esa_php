<?php
include_once '../config.php';
function getTodos($option = 'todos') {
    if($option == 'history'){
        $filename = CSV_PATH_HISTORY;
    }else{

        $filename = CSV_PATH;
    }
    $todos = [];

    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        // ignore la première ligne ( libéllé )
        fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $todos[] = ['task' => $data[0], 'completed' => $data[1], 'due_date' => $data[2], 'category' => $data[3], 'username' => $data[4]];
        }

        fclose($file);
    }

    return $todos;
}
function getCategories() {
    $filename = CSV_PATH_CATEGORY;
    $categories = [];

    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        // ignore la première ligne ( libéllé )
        fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $categories[] = $data[0];
        }

        fclose($file);
    }

    return $categories;
}

function saveTodos($todos, $option = 'save') {
    if($option == 'save'){
        $filename = CSV_PATH;
    }elseif($option == 'history'){
        $filename = CSV_PATH_HISTORY;
    }else{
        $filename = CSV_PATH;
    }
    if (file_exists($filename)) {
        $file = fopen($filename, 'w');
        // écrit la première ligne ( libéllé )
        fputcsv($file, ['task', 'completed', 'due_date', 'category', 'username']);
        foreach ($todos as $todo) {
            fputcsv($file, $todo);
        }
        fclose($file);
    }
}
function saveCategories($categories) {
    $filename = CSV_PATH_CATEGORY;
    if (file_exists($filename)) {
        $file = fopen($filename, 'w');
        // écrit la première ligne ( libéllé )
        fputcsv($file, ['category']);
        foreach ($categories as $category) {
            fputcsv($file, [$category]);
        }
        fclose($file);
    }
}

function getUsers() {
    $filename = CSV_PATH_USER;
    $users = [];
    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        fgetcsv($file);
        while (($data = fgetcsv($file)) !== FALSE) {
            $users[] = $data[0];
        }
        fclose($file);
    }
    return $users;
}

function saveUser($username) {
    $filename = CSV_PATH_USER;
    $usernames = getUsers();
    $usernames[] = $username; 
    if (file_exists($filename)) {
        $file = fopen($filename, 'w');
        // écrit la première ligne ( libéllé )
        fputcsv($file, ['users']);
        foreach ($usernames as $username) {
            fputcsv($file, [$username]);
        }
        fclose($file);
    }
}

function saveUsers($usernames) {
    $filename = CSV_PATH_USER;
    if (file_exists($filename)) {
        $file = fopen($filename, 'w');
        // écrit la première ligne ( libéllé )
        fputcsv($file, ['users']);
        foreach ($usernames as $username) {
            fputcsv($file, [$username]);
        }
        fclose($file);
    }
}

