<?php
session_start();
$page = 'profile';

require '../../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/register.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user = $userController->getUser($user_id);

if (!$user) {
    $errors[] = "Пользователь не найден.";
    $_SESSION['errors'] = $errors;

    header("Location: ../../");
    exit();
}

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
    <title>Профиль</title>

    <link rel="stylesheet" href="../../app.css">
</head>

<body>
    <link rel="stylesheet" href="../../components/header/app.css">
    <?php include '../../components/header/header.php' ?>

    <link rel="stylesheet" href="../../components/nav_bar/app.css">
    <?php include '../../components/nav_bar/nav_bar.php' ?>

    <link rel="stylesheet" href="../../components/error_form/app.css">
    <?php include '../../components/error_form/error_form.php' ?>

    <link rel="stylesheet" href="../../components/profile_card/app.css">
    <?php include '../../components/profile_card/profile_card.php' ?>

    <link rel="stylesheet" href="../../components/profile_edit/app.css">
    <?php include '../../components/profile_edit/profile_edit.php' ?>

</body>

</html>