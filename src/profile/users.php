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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Профиль</title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <header class="container header">
        <div class="header-item">
            <img src="../assets/static/beer.png" alt="beer">
        </div>
        <div class="header-item">
            <h1>Pivnuha Space</h1>
        </div>
        <div class="header-item">
            <img src="../assets/static/beer.png" alt="beer">
        </div>
    </header>

    <div class="container">
        <div class="button-group">
            <a href='../../' class='button profile-button'>На главную</a>
        </div>
    </div>

    <div class="container profile-container">
        <div class="profile-avatar">
            <img src="<?php echo htmlspecialchars($user['avatar'] ?? '../assets/static/uploads/avatar.png'); ?>" alt="Аватар" class="avatar">
        </div>
        <div class="profile-details">
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Почта:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Дата регистрации:</strong> <?php echo htmlspecialchars($user['reg_date']); ?></p>
        </div>
    </div>

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