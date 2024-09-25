<?php
session_start();
$page = 'login';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Логин</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../../app.css">
</head>

<body>
    <?php include '../../components/header/header.php'; ?>

    <?php include '../../components/nav_bar/nav_bar.php'; ?>

    <?php include '../../components/error_form/error_form.php' ?>

    <?php include '../../components/auth_form/auth_form.php' ?>

</body>

</html>