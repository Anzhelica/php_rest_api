<?php

/*
 * GET http://rest-api/api/category/read.php
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate blog category object
$category = new Category($db);

//Category  query
$result = $category->read();
// Get row count
$num = $result->rowCount();

//Check if any categories
if ($num > 0) {
    //Category array
    $category_arr         = [];
    $category_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $category_item = [
            'id'         => $row['id'],
            'name'       => $row['category_name'],
            'created_at' => $row['created_at'],
        ];

        //Push to data
        $category_arr['data'][] = $category_item;
    }

    //Turn to JSON & output
    echo json_encode($category_arr);
} else {
    // No Categories
    echo json_encode(
        ['message' => 'No Categories Found']
    );
}