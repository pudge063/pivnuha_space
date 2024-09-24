<?php
session_start();
require '../model/connect.php';

$user_id = isset($_GET['id']) ? intval($_GET['id']) : null;
if (!$user_id) {
    echo "<p style='color:red;'>Пользователь не найден</p>";
    exit();
}

if (isset($_SESSION['user_id']) && $user_id == $_SESSION['user_id']) {
    header('Location: profile.php');
    exit();
}

$query = "SELECT username, name, email, reg_date FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<p style='color:red;'>Пользователь не найден</p>";
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
    <link rel="stylesheet" href="../app.css">
</head>

<body>
    <link rel="stylesheet" href="../components/header/app.css">
    <?php include '../components/header/header.php' ?>

    <link rel="stylesheet" href="../components/nav_bar/app.css">
    <?php include '../components/nav_bar/nav_bar.php' ?>

    <link rel="stylesheet" href="../components/profile_card/app.css">
    <?php include '../components/profile_card/profile_card.php' ?>



    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id): ?>
        <div class="container avatar-upload">
            <h2>Загрузить аватар</h2>
            <form action="scripts/upload_avatar.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="avatar">Выберите файл аватара:</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" required>
                </div>
                <input type="submit" value="Загрузить" class="submit-button">
            </form>
        </div>
    <?php endif; ?>
</body>

</html>