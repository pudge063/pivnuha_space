<?php
session_start();

$page = 'register';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- DEV -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Регистрация</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../../app.css">

</head>

<body>
    <link rel="stylesheet" href="../../components/header/app.css">
    <?php include '../../components/header/header.php'; ?>

    <link rel="stylesheet" href="../../components/nav_bar/app.css">
    <?php include '../../components/nav_bar/nav_bar.php'; ?>

    <link rel="stylesheet" href="../../components/error_form/app.css">
    <?php include '../../components/error_form/error_form.php' ?>

    <link rel="stylesheet" href="../../components/auth_form/app.css">
    <?php include '../../components/auth_form/auth_form.php' ?>

</body>

</html>