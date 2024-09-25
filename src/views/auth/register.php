<?php
session_start();

$page = 'register';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Регистрация</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <?php include '../../components/header/header.php'; ?>

    <?php include '../../components/nav_bar/nav_bar.php'; ?>

    <?php include '../../components/error_form/error_form.php' ?>

    <?php include '../../components/auth_form/auth_form.php' ?>

</body>

</html>