<?php
session_start();
$page = 'profile';

require '../../controller/UserController.php';

if (!isset($_SESSION['user_id'])) {
    $errors[] = 'Вы не авторизованы.';
    $_SESSION['errors'] = $errors;
    header("Location: ../../");
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
    <meta charset="UTF-8">
    <title>Профиль</title>
</head>

<body>
    <?php include '../../components/header/header.php' ?>

    <?php include '../../components/nav_bar/nav_bar.php' ?>

    <?php include '../../components/error_form/error_form.php' ?>

    <?php include '../../components/profile_card/profile_card.php' ?>

    <?php include '../../components/profile_edit/profile_edit.php' ?>

</body>

</html>