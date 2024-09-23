<?php
require_once __DIR__ . '/connect.php';

function read_table($conn)
{
    $sql = "SELECT * FROM test1 order by -create_date limit 30";
    return $conn->query($sql);
}

function read_posts($conn)
{
    $sql = "SELECT posts.*, users.name, users.avatar FROM posts INNER JOIN users ON (posts.user_id = users.id) order by posts.date DESC limit 30";
    return $conn->query($sql);
}

function add_post($conn) {
    
}