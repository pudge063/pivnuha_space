<?php
session_start();
require '../model/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/registration.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT username, name, email, reg_date, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<p style='color:red;'>Пользователь не найден</p>";
    exit();
}

$page = 'profile';
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

    <link rel="stylesheet" href="../app.css">
</head>

<body>
    <link rel="stylesheet" href="../components/header/app.css">
    <?php include '../components/header/header.php' ?>

    <link rel="stylesheet" href="../components/nav_bar/app.css">
    <?php include '../components/nav_bar/nav_bar.php' ?>

    <link rel="stylesheet" href="../components/error_form/app.css">
    <?php include '../components/error_form/error_form.php' ?>

    <link rel="stylesheet" href="../components/profile_card/app.css">
    <?php include '../components/profile_card/profile_card.php' ?>

    <link rel="stylesheet" href="../components/profile_edit/app.css">
    <?php include '../components/profile_edit/profile_edit.php' ?>

</body>

</html>