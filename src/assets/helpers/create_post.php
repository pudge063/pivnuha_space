<?php
require_once __DIR__ . '/../../model/connect.php';

session_start();

if (isset($_SESSION['user_id']) && isset($_POST['post_content'])) {
    mysqli_set_charset($conn, "utf8");

    $user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    $text = mysqli_real_escape_string($conn, $_POST['post_content']);


    $query = "INSERT INTO posts (user_id, text) VALUES ('$user_id', '$text');";
    $result = mysqli_query($conn, $query);

    mysqli_close($conn);
}

header('Location: ../../');

exit();