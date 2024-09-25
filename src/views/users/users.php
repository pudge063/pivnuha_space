<?php
session_start();
require '../../controller/UserController.php';

$user_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$user_id) {
    $errors[] = 'Пользователь не найден.';
    $_SESSION['errors'] = $errors;
    header('Location: ../../');
    exit();
}

if (isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']) {
    header('Location: profile.php');
    exit();
}

$user = $userController->getUser($user_id);

if (!$user) {
    $errors[] = 'Пользователь не найден.';
    $_SESSION['errors'] = $errors;
    header('Location: ../../');
    exit();
}

$page = 'user';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Профиль</title>
</head>

<body>
    <?php include '../../components/header/header.php' ?>

    <?php include '../../components/nav_bar/nav_bar.php' ?>

    <?php include '../../components/profile_card/profile_card.php' ?>

</body>

</html>