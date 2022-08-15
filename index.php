<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
const DATA_FILE_NAME = 'data.json';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$tasks = [];
$data_json = file_get_contents(DATA_FILE_NAME);

if(isset($_GET['get'])) {
    echo $data_json;
}

if(isset($_GET['post'])) {
    $name = $_POST['name'];
    $task = $_POST['task'];

    $output = [];

    if(strlen($name) === 0) {
        $output['message'] = 'Name is not entered!';
        echo json_encode($output);
        exit;
    }

    if(strlen($task) === 0) {
        $output['message'] = 'Task is not entered';
        echo json_encode($output);
        exit;
    }

    if(!gettype($data_json) === 'string') {
        $output['message'] = 'data json nav string';
        echo json_encode($output);
        exit;
    }

    if(strlen($data_json) === 0) {
        $id = 0;
        $tasks[] = (object) ['id' => $id, 'name' => $name, 'task' => $task];
        file_put_contents(DATA_FILE_NAME, json_encode($tasks));
    } else {
        $tasks = json_decode($data_json);
        $lastID = $tasks[sizeof($tasks) - 1]->id;
        $newTask = (object) ['id' => $lastID + 1, 'name' => $name, 'task' => $task];
        $tasks[] = $newTask;
        file_put_contents(DATA_FILE_NAME, json_encode($tasks));
    }

    $output['message'] = 'task added!';
    echo $output['message'];
    //return json_encode($tasks);
}


//tasks[ID1 => [name, task], id2 => [name, task], ...];
// echo json_encode($tasks);

