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
            <a href='../auth/scripts/logout.php' class='button profile-button'>Выход</a>

        </div>
    </div>

    <div class="container" hidden="true" id="error-container">
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <script>
                document.getElementById('error-container').removeAttribute('hidden');
            </script>
            <div class="errors">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li style="text-align: center;"><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']);
            ?>
        <?php endif; ?>
    </div>

    <div class="container profile-container">
        <div class="profile-avatar">
            <img src="<?php echo htmlspecialchars($user['avatar'] ?? '../assets/static/default-avatar.png'); ?>" alt="Аватар" class="avatar">
        </div>
        <div class="profile-details">
            <h3><?php echo htmlspecialchars($user['username']); ?></h3>
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Почта:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Дата регистрации:</strong> <?php echo htmlspecialchars($user['reg_date']); ?></p>
        </div>
    </div>

    <!-- Блок настроек всегда открытый -->
    <div class="container settings-form">
        <h4>Редактировать профиль</h4>
        <form action="scripts/update_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" placeholder="Новый пароль">
            </div>
            <div class="form-group">
                <label for="avatar">Аватар:</label>
                <input type="file" name="avatar" id="avatar" accept="image/*">
            </div>
            <input type="submit" value="Сохранить изменения" class="submit-button">
        </form>
    </div>

</body>

</html>