<?php
session_start();
$page = 'index';

require_once __DIR__ . '/model/Post.php';
require_once __DIR__ . '/controller/PostController.php';
require_once __DIR__ . '/controller/UserController.php';

$public_key = getenv("CAPTCHA_PUBLIC_KEY");


$postController = new PostController($conn);
$posts = $postController->index();
$table_rows = $postController->read_table();

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['name'];
    $_SESSION['is_admin'] = $userController->isAdmin($user_id);
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


</head>

<body>
    <?php include 'components/header/header.php'; ?>

    <?php include 'components/nav_bar/nav_bar.php' ?>


    <div class="container">
        <p style="text-align: center; margin: 0; padding: 0;">Однажды pivnuha.space будет по умолчанию в закладках Chrome</p>
    </div>

    <?php include 'components/error_form/error_form.php' ?>

    <?php if (isset($user_id)) {
        include 'components/create_post/create_post.php';
    } ?>

    <?php if (!isset($user_id)) : ?>
        <div class="container">
            <p style="text-align: center;">Войдите, чтобы отправить пост</p>
        </div>
    <?php endif ?>

    <?php include 'components/posts/posts.php'; ?>

    <?php include 'components/beer_table/beer_table.php' ?>

</body>

</html>