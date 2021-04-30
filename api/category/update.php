<?php

/*
 * PUT http://rest-api/api/category/update.php
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$category->id = $data->id;

$category->name = $data->name;

if ($category->update()) {
    echo json_encode(
        ["message" => 'Category Updated']
    );
} else {
    echo json_encode(
        ["message" => 'Category Not Updated']
    );
}