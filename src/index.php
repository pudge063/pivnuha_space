<?php
session_start();
$page = 'index';

require_once __DIR__ . '/model/Post.php';
require_once __DIR__ . '/controller/PostController.php';

$public_key = getenv("CAPTCHA_PUBLIC_KEY");


$postController = new PostController($conn);
$posts = $postController->index();
$table_rows = $postController->read_table();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['name'];
}

$postController = new PostController($conn);
$posts = $postController->index();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- DEV -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- DEV -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Pivnuha Space!</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <link rel="stylesheet" href="components/header/app.css">
    <?php include 'components/header/header.php'; ?>

    <link rel="stylesheet" href="components/nav_bar/app.css">
    <?php include 'components/nav_bar/nav_bar.php' ?>


    <div class="container">
        <p style="text-align: center; margin: 0; padding: 0;">Однажды pivnuha.space будет по умолчанию в закладках Chrome</p>
    </div>

    <link rel="stylesheet" href="components/error_form/app.css">
    <?php include 'components/error_form/error_form.php' ?>

    <!-- добавлено в MVC -->
    <link rel="stylesheet" href="components/create_post/app.css">
    <?php include 'components/create_post/create_post.php' ?>

    <!-- добавлено в MVC -->
    <link rel="stylesheet" href="components/posts/app.css">
    <?php include 'components/posts/posts.php';?>

    <!-- добавлено в MVC -->
    <link rel="stylesheet" href="components/beer_table/app.css">
    <?php include 'components/beer_table/beer_table.php' ?>

</body>

</html>