<?php

/*
 * GET http://rest-api/api/category/read_single.php?id=1
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate Category object
$category = new Category($db);

//Get ID rom URL
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$category->read_single();

// Create array
$category_arr = [
    'id'            => $category->id,
    'title'         => $category->name,
    'body'          => $category->created_at
];

// Make JSON
print_r(json_encode($category_arr));