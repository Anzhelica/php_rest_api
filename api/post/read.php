<?php

/*
 * GET http://rest-api/api/post/read.php
 */

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & connect
$database = new Database();
$db       = $database->connect();

// Instantiate blog post object
$post = new Post($db);

//Blog post query
$result = $post->read();
// Get row count
$num = $result->rowCount();

//Check if any posts
if ($num > 0) {
    //Post array
    $posts_arr         = [];
    $posts_arr['data'] = [];

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $post_item = [
            'id'            => $row['id'],
            'title'         => $row['title'],
            'body'          => html_entity_decode($row['body']),
            'author'        => $row['author'],
            'category_id'   => $row['category_id'],
            'category_name' => $row['category_name'],
        ];

        //Push to data
        $posts_arr['data'][] = $post_item;
    }

    //Turn to JSON & output
    echo json_encode($posts_arr);
} else {
    // No Posts
    echo json_encode(
        ['message' => 'No Posts Found']
    );
}