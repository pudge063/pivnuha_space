<?php
session_start();

require_once __DIR__ . '/../../model/connect.php';

$post_id = mysqli_escape_string($conn, $_POST['post_id']);
$user_id = mysqli_escape_string($conn, $_SESSION['user_id']);
// echo $post_id . " " . "user: ". $user_id;

// validation

$query = "SELECT * FROM posts WHERE id = $post_id";
$result = mysqli_query($conn, $query);

$post = $result->fetch_assoc();

if ($post['user_id'] == $user_id) {
    $query = "DELETE FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
}

header('Location: ../../');